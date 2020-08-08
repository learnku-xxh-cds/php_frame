<?php

/**
 * 入口文件
 * 1、定义常量
 * 2、加载函数库
 * 3、启动框架
 */

// 开发期间 显示所有错误
error_reporting(E_ALL);
ini_set("display_errors","On");

// 定义常量
define('FRAME_BASE_PATH', __DIR__ . '/../');
// 环境常量
// define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
// define('IS_WIN', strpos(PHP_OS, 'WIN') !== false);


$composer_auto_load_file = FRAME_BASE_PATH . 'vendor/autoload.php';
$app_file = FRAME_BASE_PATH . 'app.php';

if (! file_exists( $composer_auto_load_file))
    die("需要执行composer install");

if (! file_exists( $app_file))
    die("app.php not found");

require_once $composer_auto_load_file; // 引入自动加载
require_once $app_file; //  框架的加载

App::get('response')->setContent( // 响应
    App::get('route')->dispatch( // 路由
       App::get('request') // 请求
    )
)->send();


