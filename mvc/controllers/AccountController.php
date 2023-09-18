<?php

class AccountController extends Controller {

    function profile($username = null) {
        // If the user wasn't passed it, attempt to pass in the user searched
        if ($username == null) { return $this->view(User); }
        $searchedUser = User::findByName($username);
        return $this->view($searchedUser == null ? null : $searchedUser);
    }

    function settings() {
        $this->allowed = ["user", "admin"];
        $this->restrictedRedirect = "login";
        if (Validator::Posted()) {
            // Update user settings, check first to upload the picture
            if ($_FILES['profilepicture']['name'] != "") {
                $uploader = new ImageUploader($_FILES["profilepicture"]);
                if ($uploader->moveFile(profilepictures, "jpg,jpeg,png,gif", $_POST['id'])) {
                    // Upload their picture and change their image path in the database, (yes it's their id but if the extension changes we gotta update)
                    db::prepared("UPDATE sz_users SET profile_img = ? WHERE id = ?", [$_POST['id'].'.'.$uploader->extension, $_POST['id']]);
                }
            }
            // Validate all the inputs and only update them if they're formatted correctly or null to erase them
            $this->validator->string("bio", $_POST, 0, 128, '/^[a-zA-Z0-9, .\/]+$/');
            $this->validator->date("birthday", $_POST, "1920-01-01", "2006-01-01");
            $this->validator->string("location", $_POST, 0, 64, '/^[a-zA-Z0-9, ]+$/');
            if ($this->validator->inputs["bio"]["valid"] == true || $_POST["bio"] == null) {
                db::prepared("UPDATE sz_users SET bio = ? WHERE id = ?", [$_POST["bio"], $_POST["id"]]);
            }
            if ($this->validator->inputs["birthday"]["valid"] == true || $_POST["birthday"] == null) {
                db::prepared("UPDATE sz_users SET birthday = ? WHERE id = ?", [$_POST["birthday"], $_POST["id"]]);
            }
            if ($this->validator->inputs["location"]["valid"] == true || $_POST["location"] == null) {
                db::prepared("UPDATE sz_users SET location = ? WHERE id = ?", [$_POST["location"], $_POST["id"]]);
            }
            // Better to just reload the page so you can see the new profile picture
            // The con here is that the validation won't show but at least if you update your picture it'll show in the navbar :D
            // It's a price I'm willing to pay, I can still use the validation report for seeing if I should update it though!
            return $this->redirectToAction('settings', 'account');
        }
        return $this->view(User);
    }

    function login() {
        if (Validator::Posted()) {
            $success = account::loginUser(Validator::Input("username"), Validator::Input("password"));
            if ($success === true) {
                $this->redirectToAction('index', 'home');
            } else {
                // If login fails send the error message to the view
                return $this->view($success);
            }
        }
        return $this->view();
    }

    function register() {
        if (Validator::Posted()) {
            $this->validator->string("email", $_POST, 0, 150, '/^\S+@\S+\.\S+$/', 'Email');
            $this->validator->string("username", $_POST, 3, 15);
            $this->validator->string("password", $_POST, 3, 25);
            if($this->validator->validateInputs()) {
                $success = account::registerUser(Validator::Input("email"), 
                                                     Validator::Input("username"), 
                                                     Validator::Input("password"));
                if ($success === true) {
                    // If they register successfully, log em in
                    $this->redirectToAction('index', 'home');
                } else {
                    return $this->view($success);
                }
            }
        }
        return $this->view();
    }

    function cart() {
        $this->allowed = ["user", "admin", "!suspended"];
        $this->restrictedRedirect = "login";
        return $this->view(Cart::getCart());
    }

    function removeFromCart($listingGuid = null) {
        $this->allowed = ["user", "admin", "!suspended"];
        $this->restrictedRedirect = "login";
        if ($listingGuid != null) {
            if (Cart::hasItem($listingGuid)) {
                Cart::removeFromCart($listingGuid); 
            }
        }
        return $this->redirectToAction('cart', 'account');
    }

    function purchaseCart() {
        $this->allowed = ["user", "admin", "!suspended"];
        $this->restrictedRedirect = "login";
        if (Cart::itemCount() > 0) {
            foreach (Cart::getCart() as $guid => $listing) {
                Listing::purchase($guid, User->id);
            }
        }
        return $this->redirectToAction('purchaseSuccess', 'account');
    }

    function purchaseSuccess($bidGuid = null) {
        $model = null;
        if (Cart::itemCount() > 0) {
            // If they're coming here from the cart purchase page
            $model = Cart::getCart();
            Cart::dropCart();
        } else {
            // Coming here from overbidding the buyout price on bid
            if ($bidGuid != null) {
                $model = Listing::findByGUID($bidGuid);
            }
        }
        return $this->view($model);
    }

    function notification($id = null) {
        $this->allowed = ["user", "admin", "!suspended"];
        $this->restrictedRedirect = "login";

        if (Validator::Posted()) {
            // If they're leaving a review!
            $this->validator->string("review", $_POST, 0, 256, '/^[a-zA-Z0-9, .\/!\']+$/', 'letters, numbers, and standard punctuation');
            if ($this->validator->validateInputs()) {
                // Add the review and complete the notification
                db::prepared("INSERT INTO reviews (lister_id, reviewer_id, review, listing_id, rating) VALUES (?, ?, ?, ?, ?)", [$_POST["lister_id"], $_POST["reviewer_id"], $_POST["review"], $_POST["listing_id"], $_POST["rating"]]);
                db::prepared("UPDATE notifications SET completed = 1 WHERE id = ?", [$id]);
                User::updateRating($_POST["lister_id"]);
            }
        }

        if ($id == null) { return $this->redirectToAction('index', 'home'); }
        $notification = Notification::findById($id);
        if (User->id !== $notification->user_id || $notification->completed === 1) {
            return $this->redirectToAction('index', 'home');
        }
        return $this->view($notification);
    }

    function acceptbid() {
        // Accepting the highest bid on an item
        if (Validator::VarSet($_POST, "listing_id") != null) {
            // If the listing exists
            $listing = Listing::findByGUID($_POST["listing_id"]);
            $listing->getBids();
            $maxBid = new Bid(0, 0, 0, 0, 0);
            foreach ($listing->bids as $bid) {
                if ($bid->bid_amount > $maxBid->bid_amount) {
                    $maxBid = $bid;
                }
            }
            if ($listing != null) {
                // Purchase it with the highest bid !
                Listing::purchase($listing->guid, $maxBid->user_id);
                return $this->redirectToAction('index', 'home');
            }
        }
        return $this->redirectToAction('index', 'home');
    }

    function logout() {
        account::logout();
        return $this->redirectToAction('index', 'home');
    }

    function suspended() {
        return $this->view();
    }

}