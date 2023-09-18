<?php

class ListingController extends Controller {

    function create() {
        $this->allowed = ["user", "!suspended"];
        // If they try to access this page without being logged in, redirect to login
        $this->restrictedRedirect = "login";
        if (Validator::Posted()) {
            // To avoid some errors with formatting
            $_POST["price"] = Validator::DollarToFloat($_POST["price"]);
            $this->validator->string("title", $_POST, 3, 32, '/^[a-zA-Z0-9, .\/!\':]+$/', 'letters, numbers, and standard punctuation');
            $this->validator->string("description", $_POST, 3, 256, '/^[a-zA-Z0-9,\/!.\' :]+$/', 'letters, numbers, and commas, and standard punctuation');
            $this->validator->number("price", $_POST, 0, 9999999999.00);
            if ($this->validator->validateInputs()) {
                // If all is good, upload their image and insert the listing into the database
                // I'm using guid here just so I can give the picture a unique name right away, it probably doesn't matter
                $guid = substr(md5(uniqid()), 0, 12);
                $filename = 'default.png';
                $success = false;
                if ($_POST["type"] == "bidding" && $_POST["price"] < 1) {
                    // If they have it as a bid and it's free, make it a normal purchase and not a bid
                    // As the buyout price on bids purchase the item and a buyout of 0 is no different from
                    // A purchase at that point
                    $_POST["type"] = "purchase";
                }

                // Depending on if it's a bid or not gotta handle it a bit differently
                switch ($_POST["type"]) {
                    case "bidding":
                            $success = db::prepared("INSERT INTO listings (guid, title, description, type, buyout, img_path, user_id, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", 
                            [$guid, $_POST["title"], $_POST["description"], "bidding", $_POST["price"], $filename, $_POST["user_id"], $_POST["tags"]]);
                        break;
                    default:
                            $success = db::prepared("INSERT INTO listings (guid, title, description, type, price, img_path, user_id, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", 
                            [$guid, $_POST["title"], $_POST["description"], "purchase", $_POST["price"], $filename, $_POST["user_id"], $_POST["tags"]]);
                        break;
                }

                // If they uploaded a picture, upload it and set their image path to the correct one
                if ($_FILES['listingpicture']['name'] != "") {
                    $uploader = new ImageUploader($_FILES["listingpicture"]);
                    if ($uploader->moveFile(listingpictures, "jpg,jpeg,png,gif", $guid)) {
                        // Upload their picture and change their image path in the database, (yes it's their id but if the extension changes we gotta update)
                        db::prepared("UPDATE listings SET img_path = ? WHERE guid = ?", [$guid.'.'.$uploader->extension, $guid]);
                    }
                }
                if ($success != false) {
                    return $this->redirectToAction('index', 'home');
                }
            }
        }
        return $this->view();
    }

    function detail($guid = null) {
        if (Validator::Posted()) {
            $this->allowed = ["user", "admin", "!suspended"];
            $this->restrictedRedirect = "login";
            $_POST["bidAmount"] = Validator::DollarToFloat($_POST["bidAmount"]);
            $this->validator->number("bidAmount", $_POST, 0, 9999999999.00);
            if ($this->validator->validateInputs()) {
                $listing = Listing::findByGUID($guid);
                Bid::submitBid($_POST["listing_id"], User->id, $_POST["bidAmount"]);
                if ($_POST["bidAmount"] >= $listing->price) {
                    // The buyout purchases the item for the customer!
                    Listing::purchase($listing->guid, User->id);
                    return $this->redirectToAction('purchaseSuccess', 'account', $guid);
                }
            }
            return $this->redirectToAction('detail', 'listing', $guid);
        }
        $listing = Listing::findByGUID($guid);
        if ($listing != null && ($listing->archived === 1 || $listing->sold === 1)) { $listing = null; } 
        return $this->view($listing);
    }

    function edit($guid = null) {
        $this->allowed = ["user", "admin", "!suspended"];
        $listing = Listing::findByGUID($guid);
        if ($listing != null) {
            if ((User != null && User->id === $listing->user_id) || (User != null && User->isAdmin())) {
                return $this->view($listing);
            }
        }
        // If they aren't an admin or the owner of the listing they can't edit it!
        return $this->redirectToAction('_restricted', 'home');       
    }

    function addToCart($listingGuid = null) {
        $this->allowed = ["user", "admin", "!suspended"];
        if ($listingGuid != null) {
            if (!Cart::hasItem($listingGuid)) {
                Cart::addToCart($listingGuid); 
            }
            return $this->redirectToAction('detail', 'listing', $listingGuid);
        }
        return $this->redirectToAction('index', 'home');
    }

    function removeFromCart($listingGuid = null) {
        $this->allowed = ["user", "admin", "!suspended"];
        if ($listingGuid != null) {
            if (Cart::hasItem($listingGuid)) {
                Cart::removeFromCart($listingGuid); 
            }
            return $this->redirectToAction('detail', 'listing', $listingGuid);
        }
        return $this->redirectToAction('index', 'home');
    }

    function submitBid($listingGuid = null) {
        $this->allowed = ["user", "admin", "!suspended"];
        if ($listingGuid != null) {
            // Add a bid to the listing
            return $this->redirectToAction('detail', 'listing', $listingGuid);
        }
        return $this->redirectToAction('index', 'home');
    }

}