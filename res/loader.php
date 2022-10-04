<?php

use Tracy\Debugger;

require_once PROJECT_DIR . "vendor/autoload.php";

Debugger::enable(Debugger::DETECT, PROJECT_DIR . 'logs', "info@3nicom.cz");
//Debugger::enable(Debugger::DEVELOPMENT, PROJECT_DIR . "logs", "info@3nicom.cz");
//Debugger::enable(Debugger::PRODUCTION, PROJECT_DIR . "logs", "info@3nicom.cz");
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_STRICT & ~E_WARNING);
ini_set("display_errors", 1);

function autoload($class) {
    $sclass = strtolower($class);
    $classPath = str_replace('_', '/', $class);
    if (strpos($class, 'dbI') === 0 && $class != 'dbI' && $class != 'dbItem' && $class != 'dbItemProperty' && $class != 'dbImage') {
        include PROJECT_DIR . "res/classes/db/interface/" . "$classPath.php";
    } elseif (strpos($class, 'db') === 0) {
        include PROJECT_DIR . 'res/classes/db/' . "$classPath.php";
    } elseif (strpos($class, 'Interface') === 0) {
        include PROJECT_DIR . "res/classes/db/interface/" . "$classPath.php";
    } elseif (strpos($class, 'Helper') === 0) {
        include PROJECT_DIR . "res/classes/" . "$classPath.php";
    } elseif (strpos($class, '3n')) {
        include PROJECT_DIR . "res/classes/" . "$class.php";
    } elseif (strpos($class, 'Smarty') === 0) {
        include PROJECT_DIR . "smarty/sysplugins/" . "$sclass.php";
    } elseif (strpos($class, 'Image_Transform_Driver_GD') === 0) { //PEAR
        include $classPath . ".php";
    } elseif (strpos($class, 'kcfinder') === 0) { //PEAR
//		include PROJECT_DIR . 'ckeditor/' . str_replace("\\", "/", $class) . ".php";
    } else {
        if (file_exists(PROJECT_DIR . "res/classes/" . "$classPath.php")) {
            include PROJECT_DIR . "res/classes/" . "$classPath.php";
        } else {
            include PROJECT_DIR . "res/classes/" . "$class.php";
        }
    }
}

spl_autoload_register("autoload");
if (file_exists(PROJECT_DIR . "vendor/autoload.php")) {
    require_once PROJECT_DIR . "vendor/autoload.php";
}

Cache::init();

$config = Registry::getConfig();

Log::init($config->log);
if (Registry::isProductionMode()) {
    FB::setEnabled(false);
} else {
//	Debugger::$strictMode = true;
    FB::setEnabled(true);
}


if ($config->debug->profiler->enabled && !Registry::isProductionMode()) {
    if (extension_loaded('xhprof')) {
        require '/usr/local/opt/php56-xhprof/xhprof_lib/utils/xhprof_lib.php';
        require '/usr/local/opt/php56-xhprof/xhprof_lib/utils/xhprof_runs.php';
        xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
    }
}


$namespace = Registry::getConfig()->database->namespace;
$configArray = Registry::getConfig()->database->{$namespace}->toArray();
$dibi = dibi::connect($configArray);
//dibi::setConnection($dibi);
?>