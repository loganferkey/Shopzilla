<?php

class View {
    protected $file, $title = SITE_TITLE, $buffer, $layout = DEFAULT_LAYOUT;
    /**
     * Renders the view from a given controller
     * @param string $viewName The name of the page you want to render, i.e (index)
     * @param string $controllerName The name of the controller, i.e (Home)
     * @return void Doesn't return anything only renders the page
     */
    public function render($viewName, $controllerName) {
        if (file_exists(_views.$controllerName.DS.$viewName.'.php')) {
            // All buffer does is capture the contents of the file between buffer functions
            // And renders it inside the layout
            $this->capture();
            include(_views.$controllerName.DS.$viewName.'.php');
            $this->end();
            include(_views.'shared'.DS.$this->layout.'.php');
        } else {
            // If the view doesn't exist, render the error page
            include(_views.'Home'.DS.'_error.php');
        }
    }

    // Returns the body contents of the view
    public function renderBody() {
        return $this->file;
    }

    // Start output buffer capture
    public function capture() {
        ob_start();
    }

    // End the output buffer and capture the contents in the file property
    public function end() {
        $this->file = ob_get_clean();
    }

    // Gets and sets the tile of the page
    public function title($title) {
        $this->title = $title;
        return $this->title;
    }
}