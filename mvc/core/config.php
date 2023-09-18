<?php

// MVC Config
// Name of your base controller (if no controller found)
// And name of the base view in each controller folder, index is default
define('BASE_CONTROLLER', 'Home');
define('BASE_VIEW', 'index');
define('ERROR_VIEW', '_error');
define('ACCESS_RESTRICTED', '_restricted');
define('CONTROLLER', 'Controller');
// !!! Root file/folders project is in !!! You'll see why this is important in the layout file
$project_root = str_replace('index.php', '', str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']));
define('PROJ_ROOT', $project_root);
define('profilepictures', ROOT.DS.'images'.DS.'profile_pictures'.DS);
define('listingpictures', ROOT.DS.'images'.DS.'listing_pictures'.DS);
define('browser_pp', PROJ_ROOT.'images/profile_pictures/');
define('browser_lp', PROJ_ROOT.'images/listing_pictures/');
// If no layout set in controller, use default layout
// Default layout is the filename of your header file included in every page, mvc/views/shared/layout.php
define('DEFAULT_LAYOUT', '_layout');
define('SITE_TITLE', 'Website');