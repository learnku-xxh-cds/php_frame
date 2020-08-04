<?php

/**
 * 入口文件
 * 1、定义常量
 * 2、加载函数库
 * 3、启动框架
 */
error_reporting(E_ALL);
ini_set("display_errors","On");

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

App::get('response')->setContent(
    App::get('route')->dispatch(
       App::get('request')
    )
)->send();


