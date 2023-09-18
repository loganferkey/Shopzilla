<?php

class Controller {
    protected $controller;
    protected $action;
    protected $validator;
    protected $allowed = true;
    protected $restrictedRedirect = "restricted";
    public $view;

    public function __construct($action) {
        $this->controller = str_replace('Controller', '', get_class($this));
        $this->action = $action;
        $this->view = new View();
        $this->validator = new Validator();
        // Check to make sure that when accessed the user is allowed to see this
        if ($this->allowed !== true) {
            // If there are role restrictions for this controller validate against user
            if (!Access::hasAccess(User->roles, $this->allowed)) {
                if ($this->restrictedRedirect == "restricted") {
                    // If you change the restrictedRedirect to login it'll redirect to the login page instead
                    $this->redirectToAction(ACCESS_RESTRICTED, BASE_CONTROLLER);
                } else {
                    $this->redirectToAction('login', 'account');
                }
            }
        }
    }

    protected function view($model = null) {
        // Allows you to reference the passed in model as Model inside the view and grab the data
        define('Model', $model);
        // Check allowed again incase this view has specific permissions
        if ($this->allowed !== true) {
            // If there are role restrictions for this controller validate against user
            if (!Access::hasAccess(User->roles, $this->allowed)) {
                // User not allowed access based on either suspension, lack of role, or not logged in
                if (User->suspended == 1 && in_array("!suspended", $this->allowed)) {
                    return $this->redirectToAction('suspended', 'account');
                }
                if ($this->restrictedRedirect == "restricted") {
                    // If you change the restrictedRedirect to login it'll redirect to the login page instead
                    return $this->redirectToAction(ACCESS_RESTRICTED, BASE_CONTROLLER);
                } else {
                    return $this->redirectToAction('login', 'account');
                }
            }
        }
        // Render the page corresponding to the parent function this was ran in
        return $this->view->render(debug_backtrace()[1]['function'] ?? BASE_VIEW, $this->controller);
    }

    protected function redirectToAction($view, $controller, ...$args) {
        if (!headers_sent()) {
            // Returning an action on a seperate controller
            header('Location: '.route($controller, $view, $args));
        } else {
            // Whatever controller you want
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.route($controller, $view, $args).'"';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.route($controller, $view, $args).'"/>';
        }
    }
}