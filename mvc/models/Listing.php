<?php

class Listing {
    public $guid, $title, $description, $type, $price, $img_path, $user_id, $user = null, $sold, $tags, $created, $archived, $bids = [];
    public function __construct($guid, $title, $description, $type, $price, $img_path, $user_id, $sold, $tags, $created, $archived) {
        $this->guid = $guid;
        $this->title = $title;
        $this->description =$description;
        $this->type = $type;
        $this->price = $price;
        $this->img_path = $img_path;
        $this->user_id = $user_id;
        $this->sold = $sold;
        $this->tags = $tags;
        $this->created = $created;
        $this->archived = $archived;
        $this->bids = [];
    }

    public static function all($type = null, $tags = null, $search = null, $hideArchived = null, $limit = null) {
        // This is a pretty long winded filter but I wanted to do it this way instead of array_filter()
        // For performance reasons and memory saving
        // Thanks ChatGPT :)
        $params = array();
        $filter = "";
        if ($type) {
            if ($type == "all") { // do nothing, show all types 
            } else {
                if ($filter != "") { $filter .= " AND "; }
                $filter .= "type = :type";
                $params['type'] = $type;
            }
        }
        if ($tags) {
            if ($tags == "all") { // do nothing, show all tags
            } else {
                if ($filter != "") { $filter .= " AND "; }
                $filter .= "FIND_IN_SET(:tag, tags) > 0";
                $params['tag'] = $tags;
            }
        }
        if ($search != null && trim($search) != "") {
            if ($filter != "") { $filter .= " AND "; }
            $filter .= "(title LIKE :search OR description LIKE :search)";
            $params['search'] = "%" . $search . "%";
        }
        if ($hideArchived === true) {
            if ($filter != "") { $filter .= " AND "; }
            $filter .= "archived = 0";
        }
        $q = "SELECT * FROM listings";
        if ($filter != "") { $q .= " WHERE " . $filter; }
        $q .= " ORDER BY created DESC";
        if ($limit != null) { $q .= " LIMIT $limit"; }

        $query = db::prepared($q, $params);
        $dbListings = db::dump($query);
        unset($query);
        $allListings = ['listings' => [], 'count' => 0];
        foreach ($dbListings as $l) {
            // If i'm not displayed the archived ones, continue before we add it to the list
            $price = $l['type'] === 'bidding' ? $l['buyout'] : $l['price'];
            $allListings['count'] = array_push($allListings['listings'], new Listing($l['guid'], $l['title'], $l['description'], $l['type'], $price, $l['img_path'], $l['user_id'], $l['sold'], $l['tags'], $l['created'], $l['archived']));
        }
 
        return $allListings;
    }

    public static function findByGUID($guid) {
        $query = db::prepared("SELECT * FROM listings WHERE guid = ? LIMIT 1", [$guid]);
        $l = db::pull($query);
        unset($query);
        if ($l != null) { $price = $l['type'] === 'bidding' ? $l['buyout'] : $l['price']; }
        return $l == null ? null : new Listing($l['guid'], $l['title'], $l['description'], $l['type'], $price, $l['img_path'], $l['user_id'], $l['sold'], $l['tags'], $l['created'], $l['archived']);
    }

    public function getUser() {
        $this->user = User::findById($this->user_id);
        return $this->user;
    }

    public function getUserListings($limit = null) {
        if ($limit != null) {
            $query = db::prepared("SELECT * FROM listings WHERE user_id = ? AND guid <> ? ORDER BY created DESC LIMIT $limit", [$this->user_id, $this->guid]);
        } else { $query = db::prepared("SELECT * FROM listings WHERE user_id = ? AND guid <> ? ORDER BY created DESC", [$this->user_id, $this->guid]); }
        $dbListings = db::dump($query);
        unset($query);
        $userListings = ['listings' => [], 'count' => 0];
        if ($dbListings != null) {
            foreach ($dbListings as $l) {
                $price = $l['type'] === 'bidding' ? $l['buyout'] : $l['price'];
                $userListings['count'] = array_push($userListings['listings'], new Listing($l['guid'], $l['title'], $l['description'], $l['type'], $price, $l['img_path'], $l['user_id'], $l['sold'], $l['tags'], $l['created'], $l['archived']));
            }
        }
        return $userListings;
    }

    public static function getListingsFromUser($userId, $limit = null) {
        if ($limit != null) {
            $query = db::prepared("SELECT * FROM listings WHERE user_id = ? ORDER BY created DESC LIMIT $limit", [$userId]);
        } else { $query = db::prepared("SELECT * FROM listings WHERE user_id = ? ORDER BY created DESC", [$userId]); }
        $dbListings = db::dump($query);
        unset($query);
        $userListings = ['listings' => [], 'count' => 0];
        if ($dbListings != null) {
            foreach ($dbListings as $l) {
                $price = $l['type'] === 'bidding' ? $l['buyout'] : $l['price'];
                $userListings['count'] = array_push($userListings['listings'], new Listing($l['guid'], $l['title'], $l['description'], $l['type'], $price, $l['img_path'], $l['user_id'], $l['sold'], $l['tags'], $l['created'], $l['archived']));
            }
        }
        return $userListings;
    }

    public function getRelatedListings($limit = null) {
        if ($limit != null) {
            $query = db::prepared("SELECT * FROM listings WHERE tags = ? AND guid <> ? ORDER BY created DESC LIMIT $limit", [$this->tags, $this->guid]);
        } else { $query = db::prepared("SELECT * FROM listings WHERE tags = ? AND guid <> ? ORDER BY created DESC", [$this->tags, $this->guid]); }
        $dbListings = db::dump($query);
        unset($query);
        $relatedListings = ['listings' => [], 'count' => 0];
        if ($dbListings != null) {
            foreach ($dbListings as $l) {
                $price = $l['type'] === 'bidding' ? $l['buyout'] : $l['price'];
                $relatedListings['count'] = array_push($relatedListings['listings'], new Listing($l['guid'], $l['title'], $l['description'], $l['type'], $price, $l['img_path'], $l['user_id'], $l['sold'], $l['tags'], $l['created'], $l['archived']));
            }
        }
        return $relatedListings;
    }

    public function getBids() {
        $this->bids = [];
        $query = db::prepared("SELECT * FROM bids WHERE listing_id = ?", [$this->guid]);
        $bids = db::dump($query);
        unset($query);
        if ($bids != null) {
            foreach ($bids as $bid) {
                array_push($this->bids, new Bid($bid['id'], $bid['listing_id'], $bid['user_id'], $bid['bid_amount'], $bid['created']));
            }
            return $this->bids;
        }
        return null;
    }

    public function getFormattedPrice($largeDecimals) {
        if ($this->type === 'bidding') { return 'Bidding'; }
        if ($this->price < 1) { return 'FREE'; }
        if ($this->price >= 10000) {
            $suffix = '';
            if ($this->price > 1000000000) { $suffix = "B"; $divisor = 1000000000; }
            else {
                $suffix = $this->price > 999999.99 ? "M" : "K";
                $divisor = $this->price > 999999.99 ? 1000000 : 1000;
            }

            return '$'.number_format(round($this->price/$divisor, $largeDecimals), $largeDecimals) . $suffix;
          }
          return '$'.number_format($this->price, 2, '.', ',');
    }
    
    public static function updateArchived($guid, $bool) {
        if ($bool === true) {
            db::prepared("UPDATE listings SET archived = 1 WHERE guid = ?", [$guid]);
        } else {
            db::prepared("UPDATE listings SET archived = 0 WHERE guid = ?", [$guid]);
        }
    }

    public static function updateSold($guid, $bool) {
        // Eventually I'd make this so it deletes the sales and reviews but I didn't quite have time
        if ($bool === true) {
            db::prepared("UPDATE listings SET sold = 1 WHERE guid = ?", [$guid]);
        } else {
            db::prepared("UPDATE listings SET sold = 0 WHERE guid = ?", [$guid]);
        }
    }

    public static function purchase($listingId, $userId) {
        $listing = Listing::findByGUID($listingId);
        // Set the listing to sold and create a sale for the purchase
        db::prepared("UPDATE listings SET sold = 1 WHERE guid = ?", [$listing->guid]);
        db::prepared("INSERT INTO sales (listing_id, user_id) VALUES (?, ?)", [$listing->guid, $userId]);
        // Send a notification to the user upon completion of the purchase so they can leave a review
        $title = "Purchased $listing->title";
        $type = $listing->type;
        $description = "You have successfully purchased this item! Congratulations! Please leave a review below based on your item/experience with the lister. You can either do it now or at a later date by revisiting this notification.";
        if ($listing->type == "bidding") {
            $description = "You have successfully bidded over the buyout price or your bid was selected by the lister, congratulations on your new item! Please leave a review below based on your item/experience with the lister, you can either do it now or at a later date by revisiting this notification, thank you.";
        }
        // Sending the notification!
        db::prepared("INSERT INTO notifications (title, description, type, completed, user_id, listing_id) VALUES (?, ?, ?, ?, ?, ?)", [$title, $description, $type, 0, $userId, $listing->guid]);
    }

}