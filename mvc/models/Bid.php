<?php

class Bid {
    public $id, $listing_id, $user_id, $user, $bid_amount, $created;
    public function __construct($id, $listing_id, $user_id, $bid_amount, $created = null) {
        $this->id = $id;
        $this->listing_id = $listing_id;
        $this->user_id = $user_id;
        $this->bid_amount = $bid_amount;
        $this->created = $created;
    }

    public static function submitBid($listing_id, $user_id, $bid_amount) {
        db::prepared("INSERT INTO bids (listing_id, user_id, bid_amount) VALUES (?, ?, ?)", [$listing_id, $user_id, $bid_amount]);
    }

    public function getFormattedPrice($largeDecimals) {
        if ($this->bid_amount >= 10000) {
            $suffix = '';
            if ($this->bid_amount > 1000000000) { $suffix = "B"; $divisor = 1000000000; }
            else {
                $suffix = $this->bid_amount > 999999.99 ? "M" : "K";
                $divisor = $this->bid_amount > 999999.99 ? 1000000 : 1000;
            }

            return '$'.number_format(round($this->bid_amount/$divisor, $largeDecimals), $largeDecimals) . $suffix;
          }
          return '$'.number_format($this->bid_amount, 2, '.', ',');
    }

    public function getUser() {
        $this->user = User::findById($this->user_id);
        return $this->user;
    }

    public function getDate() {
        if ($this->created == null) { return 'NO DATE!'; }
        $date = new DateTime($this->created);
        return $date->format('F jS, Y H:ia');
    }
}