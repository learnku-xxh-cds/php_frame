<?php

/**
 * 入口文件
 * 1、定义常量
 * 2、加载函数库
 * 3、启动框架
 */

// 定义常量
define('FRAME_BASE_PATH', __DIR__ . '/../');
// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
define('IS_WIN', strpos(PHP_OS, 'WIN') !== false);

//加载函数库
$file = FRAME_BASE_PATH . 'vendor/autoload.php';
if (file_exists($file)) {
    require $file;
} else {
    die("include composer autoload.php fail");
}

spl_autoload_register(function ($class) {
    if (strpos($class, 'core\\') === 0) {
        $name = substr($class, strlen('core'));
        $classPath = FRAME_BASE_PATH . "core" . strtr($name, '\\', DIRECTORY_SEPARATOR) . '.php';
        if (file_exists($classPath)) {
            include $classPath;
            return true;
        } else {
            return false;
        }
    }
});


if (file_exists(FRAME_BASE_PATH . 'app.php')) {
    $app = require FRAME_BASE_PATH . 'app.php';
} else {
    die("include frame app.php fail");
}



//echo $app->get('request')->getMethod();

//启动框架
//App::getApp()->get('request')->getMethod()
//App::getApp()->get('response')->setContent(
//    'hello'
//)->withHeader('token','123456')->send();
