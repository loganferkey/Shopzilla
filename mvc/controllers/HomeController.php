<?php

class HomeController extends Controller {

    function index() {

        // Sorting
        $typeSort = null;
        $tagSort = null;
        $search = null;

        if (Validator::Posted()) {
            $typeSort = Validator::VarSet($_POST, "type");
            $tagSort = Validator::VarSet($_POST, "tags");
            $search = Validator::VarSet($_POST, "search");
        }

        return $this->view(Listing::all($typeSort, $tagSort, $search, true));
    }

    function about() {
        return $this->view();
    }

    function _error() {
        // Important this view is kept!
        // Redirects here on page(s) not found
        return $this->view();
    }

    function _restricted() {
        // Important this view is kept!
        // Redirects here on no access to page
        return $this->view();
    }

}