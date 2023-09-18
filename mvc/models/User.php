<?php

class User {

    public $id, $username, $email, $roles, $rating, $bids = null, $listings = null, $profilePicture, $suspended, $bio, $location, $birthday, $reviews = null;

    public function __construct($id, $username, $email, $roles, $rating, $profilePicture, $suspended, $bio, $location, $birthday) {
        // I originally had this just load a user given Id but I had some query memory overflow errors so I had to remove it :P
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        // Roles are saved as a string like "user,admin,superadmin"
        $this->roles = explode(",", $roles);
        $this->rating = $rating;
        $this->profilePicture = $profilePicture;
        $this->suspended = $suspended;
        $this->bio = $bio;
        $this->location = $location;
        $this->birthday = $birthday;
        return $this;
    }

    // This ended up being more like a repository, which I don't think is inherently bad
    // This being a wrapper for my database and specific use cases I think reaches what a model is going for

    public static function findByName($name) {
        $query = db::prepared("SELECT * FROM sz_users WHERE LOWER(username) LIKE LOWER(?) LIMIT 1", [$name]);
        $u = db::pull($query);
        unset($query);
        return $u == null ? null : new User($u['id'], $u['username'], $u['email'], $u['roles'], $u['rating'], $u['profile_img'], $u['suspended'], $u['bio'], $u['location'], $u['birthday']);
    }

    public static function findById($id) {
        $query = db::prepared("SELECT * FROM sz_users WHERE id = ? LIMIT 1", [$id]);
        $u = db::pull($query);
        unset($query);
        // Change this to populate a array of user objects
        return $u == null ? null : new User($u['id'], $u['username'], $u['email'], $u['roles'], $u['rating'], $u['profile_img'], $u['suspended'], $u['bio'], $u['location'], $u['birthday']);
    }

    public static function all() {
        $query = db::query("SELECT * FROM sz_users");
        $allUsers = ['users' => [], 'count' => 0];
        $dbUsers = db::dump($query);
        unset($query);
        foreach ($dbUsers as $u) {
            $count = array_push($allUsers['users'], new User($u['id'], $u['username'], $u['email'], $u['roles'], $u['rating'], $u['profile_img'], $u['suspended'], $u['bio'], $u['location'], $u['birthday']));
            $allUsers['count'] = $count;
        }
        return $allUsers;
    }

    public static function updateSuspended($id, $suspended) {
        if ($suspended === true) {
            db::query("UPDATE sz_users SET suspended = 1 WHERE id = $id");
        } else {
            db::query("UPDATE sz_users SET suspended = 0 WHERE id = $id");
        }
    }

    public static function updateRoles($id, $role) {
        switch ($role) {
            case "user":
                db::query("UPDATE sz_users SET roles = 'user' WHERE id = $id");
                break;
            case "admin":
                db::query("UPDATE sz_users SET roles = 'user,admin' WHERE id = $id");
                break;
            default: 
                db::query("UPDATE sz_users SET roles = 'user' WHERE id = $id");
                break;
        }
    }

    public function isAdmin() {
        return in_array('admin', $this->roles);
    }

    public function getRatingStars($size) {
        $html = '';
        for($i = 0; $i < 5; $i++) {
            if ($i < round($this->rating)) {
                $html = $html.'<div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-'.$size.' h-'.$size.' text-red-600">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
              </svg></div>';
            } else {
                $html = $html.'<div><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-'.$size.' h-'.$size.'">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                </svg></div>';
            }
         }
         return $html;
    }

    public function getListings() {
        $this->listings = Listing::getListingsFromUser($this->id, 5);
    }

    public function getReviews() {
        $this->reviews = Review::getReviewsForUser($this->id, 5);
    }

    public static function updateRating($userId) {
        $reviews = Review::getReviewsForUser($userId, 999);
        if ($reviews != null) {
            // Loop through and calculate rating for the user and update it
            $rating = 0;
            foreach ($reviews as $review) {
                $rating = $rating + $review->rating;
            }
            $rating = $rating / count($reviews);
            db::prepared("UPDATE sz_users SET rating = ? WHERE id = ?", [$rating, $userId]);
        } else {
            // Otherwise the user's rating is 0 :P
            db::prepared("UPDATE sz_users SET rating = 0 WHERE id = ?", [$userId]);
        }
    }

    public function getBids($userId) {
        // I don't think I need this, there's a function on listings for this already
    }
}