<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('_mvc', ROOT.DS.'mvc'.DS);
define('_core', _mvc.'core'.DS);
define('_models', _mvc.'models'.DS);
define('_controllers', _mvc.'controllers'.DS);
define('_views', _mvc.'views'.DS);
define('_libs', ROOT.DS.'libs'.DS);

$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

// Place your libraries in the libs folder
// Core is restricted to files that are required
// for this MVC framework and routing to function properly
require_once(_libs.'logger.php');
require_once(_libs.'pdo.php');
require_once(_libs.'validator.php');
require_once(_libs.'account.php');
require_once(_core.'config.php');
require_once(_core.'helper.php');

spl_autoload_register(function($className) {
    $includes = [
        _core,
        _controllers,
        _models,
    ];
    foreach ($includes as $directory) {
        $filepath = $directory.$className.'.php';
        if (file_exists($filepath)) {
            require_once $filepath;
        }
    }
});

// Library that checks for user in session
// Should be after spl_autoload_register()
require_once(_libs.'auth.php');
Router::route($url);

