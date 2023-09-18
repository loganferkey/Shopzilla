<?php

class Notification {

    public $id, $title, $description, $type, $completed, $user_id, $user = null, $listing_id, $listing = null, $created;
    public function __construct($id, $title, $description, $type, $completed, $user_id, $listing_id, $created) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->type = $type;
        $this->completed = $completed;
        $this->user_id = $user_id;
        $this->listing_id = $listing_id;
        $this->created = $created;
    }

    public static function count() {
        if (User == null) { return 0; }
        $count = self::getNotificationsFromUser(User->id);
        return self::getNotificationsFromUser(User->id) == null ? 0 : count($count);
    }

    public static function findById($id) {
        $query = db::prepared("SELECT * FROM notifications WHERE id = ? LIMIT 1", [$id]);
        $n = db::pull($query);
        unset($query);
        return $n == null ? null : new Notification($n['id'], $n['title'], $n['description'], $n['type'], $n['completed'], $n['user_id'], $n['listing_id'], $n['created']);
    }

    public static function getNotificationsFromUser($userId) {
        $query = db::prepared("SELECT * FROM notifications where user_id = ? AND completed = 0 ORDER BY created DESC", [$userId]);
        $dbNotifs = db::dump($query);
        $notifs = [];
        if ($dbNotifs != null) {
            foreach ($dbNotifs as $n) {
                array_push($notifs, new Notification($n['id'], $n['title'], $n['description'], $n['type'], $n['completed'], $n['user_id'], $n['listing_id'], $n['created']));
            }
        } else { $notifs = null; }
        unset($query);
        return $notifs;
    }

    public function getListing() {
        $this->listing = Listing::findByGUID($this->listing_id);
    }

    public function getDate() {
        if ($this->created == null) { return 'NO DATE!'; }
        $date = new DateTime($this->created);
        return $date->format('m/d/Y');
    }

}

?>