<?php

class AdminController extends Controller {

    public function __construct($action) {
        parent::__construct($action);
        // Admin only!
        $this->allowed = ['admin', 'superadmin', '!suspended'];
    }
    
    function index() {
        if (Validator::Posted()) {
            if (isset($_POST['save_changes'])) {
                foreach ($_POST['users'] as $id => $info) {
                    if (isset($info["suspended"]) && $info["suspended"] === "on") {
                        User::updateSuspended($id, true);
                        User::updateRoles($id, $info["role"]);
                    } else {
                        User::updateSuspended($id, false);
                        User::updateRoles($id, $info["role"]);
                    }
                }
            }
        }
        return $this->view(User::all());
    }

    function listings() {
        if (Validator::Posted()) {
            foreach ($_POST['listings'] as $id => $info) {
                if (isset($info["archived"]) && $info["archived"] === "on") {
                    Listing::updateArchived($id, true);
                } else {
                    Listing::updateArchived($id, false);
                }
                if (isset($info["sold"]) && $info["sold"] === "on") {
                    Listing::updateSold($id, true);
                } else {
                    Listing::updateSold($id, false);
                }
            }
        }
        return $this->view(Listing::all(null, null, null, null, null));
    }

}