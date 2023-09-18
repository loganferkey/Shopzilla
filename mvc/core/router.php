<?php

class Router {
    /**
     * Given the specified url, calls the correct controller and action to render the page
     * @param array $url The route you wish to travel to i.e (home/ or account/login)
     * @return void Doesn't return anything only calls the controllers
     */
    public static function route($url) {
        // Grab the controller from the url or the base controller if not found
        $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]).CONTROLLER : BASE_CONTROLLER.CONTROLLER;
        array_shift($url);

        // Grab the action/view from the url or the base view if not found
        $action = (isset($url[0]) && $url[0] != '') ? $url[0] : BASE_VIEW;
        array_shift($url);

        // Get the query string and create the instance of controller requested
        $queryString = $url;
        $dispatch = null;
        try {
            // If a controller with the requested path exists, assign it to dispatch to ship out
            $dispatch = new $controller(strtolower($action));
        } catch (Error $ex) {
            // Otherwise default the controller to the home controller and index page
            $controller = BASE_CONTROLLER.CONTROLLER;
            $dispatch = new $controller($action);
        }

        // Check if the controller has the action for the requested url and call it
        // Default is Home/index, so if you don't have that setup you're in trouble
        if (method_exists($controller, $action)) {
            call_user_func_array([$dispatch, $action], $queryString);
        } else {
            // If the action is something it shouldn't be, and it doesn't exist, make it BASE_VIEW (i.e index)
            $action = BASE_VIEW;
            if (method_exists($controller, BASE_VIEW)) {
                call_user_func_array([$dispatch, BASE_VIEW], $queryString);
            } else {
                // If all else fails and there's no default (index) view on the controller, 
                // Route the user to the home controller's _error (page not found) action
                $controller = BASE_CONTROLLER;
                $dispatch = new ($controller.CONTROLLER)(ERROR_VIEW);
                if (method_exists($controller.CONTROLLER, ERROR_VIEW)) {
                    call_user_func_array([$dispatch, ERROR_VIEW], $queryString);
                }
            }
        }
    }
}
