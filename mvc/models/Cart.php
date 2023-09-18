<?php

class Cart {

    public static function addToCart($listingGuid) {
        self::init();
        $listing = Listing::findByGUID($listingGuid);
        // Make sure they aren't sold, archived, and they're a purchase and not a bid
        if ($listing != null && $listing->type == 'purchase' && $listing->sold == 0 && $listing->archived == 0) {
            // Only add it if the guid is correct
            $_SESSION["cart"][$listingGuid] = $listing;
        }
    }
    public static function removeFromCart($listingGuid) {
        self::init();
        unset($_SESSION["cart"][$listingGuid]);
    }
    public static function hasItem($listingGuid) {
        self::init();
        if (isset($_SESSION["cart"][$listingGuid])) {
            return true;
        }
        return false;
    }
    public static function getCart() {
        self::init();
        return $_SESSION["cart"];
    }
    public static function itemCount() {
        self::init();
        return count($_SESSION["cart"]);
    }
    public static function init() {
        self::checkStart();
        if (!isset($_SESSION["cart"])) {
            // Initialize the variable in session so when it's referred to it doesn't error
            $_SESSION["cart"] = [];
        }
    }
    public static function checkStart() {
        if (session_id() == "") {
            session_start();
        }
    }
    public static function dropCart() {
        self::init();
        $_SESSION["cart"] = [];
    }

}