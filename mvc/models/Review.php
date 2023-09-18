<?php

class Review {
    public $id, $lister_id, $lister = null, $reviewer_id, $reviewer = null, $review, $listing_id, $listing = null, $rating;
    public function __construct($id, $lister_id, $reviewer_id, $review, $listing_id, $rating) {
        $this->id = $id;
        $this->lister_id = $lister_id;
        $this->reviewer_id = $reviewer_id;
        $this->review = $review;
        $this->listing_id = $listing_id;
        $this->rating = $rating;
    }

    // It's pretty nice having these functions made!
    public function getLister() {
        $this->lister = User::findById($this->lister_id);
    }

    public function getReviewer() {
        $this->reviewer = User::findById($this->reviewer_id);
    }

    public function getListing() {
        $this->listing = Listing::findByGUID($this->listing_id);
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

    public static function getReviewsForUser($userId, $limit) {
        $query = db::prepared("SELECT * FROM reviews WHERE lister_id = ? LIMIT $limit", [$userId]);
        $dbReviews = db::dump($query);
        $reviews = [];
        if ($dbReviews != null) {
            foreach ($dbReviews as $r) {
                array_push($reviews, new Review($r['id'], $r['lister_id'], $r['reviewer_id'], $r['review'], $r['listing_id'], $r['rating']));
            }
        } else { $reviews = null; }
        return $reviews;
    }

}