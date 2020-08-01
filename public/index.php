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
$composer_auto_load_file = FRAME_BASE_PATH . 'vendor/autoload.php';
$app_file = FRAME_BASE_PATH . 'app.php';

if (! file_exists( $composer_auto_load_file))
    die("please exec composer install");

if (! file_exists( $app_file))
    die("app.php not found");

require_once $composer_auto_load_file;
require_once $app_file;

//echo $app->get('request')->getMethod();
echo App::getApp()->get('route')->dispatch(
    App::getApp()->get('request')
);


var_dump(
    App::getApp()->get('config')->get('database.connections')
);

