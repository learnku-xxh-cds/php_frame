<?php


// 开发期间 显示所有错误
error_reporting(E_ALL);
ini_set("display_errors","On");

date_default_timezone_set("Asia/Shanghai");


require_once  __DIR__ . '/../vendor/autoload.php'; // 引入自动加载
require_once __DIR__ . '/../app.php';   // 框架的文件


// 绑定request
app()->bind(\core\request\RequestInterface::class,function (){
    return \core\request\PhpRequest::create(
        $_SERVER['REQUEST_URI'],$_SERVER['REQUEST_METHOD'],$_SERVER
    );
});

app('response')->setContent( // 响应
    app('route')->dispatch( // 路由
       app(\core\request\RequestInterface::class) // 请求
    )
)->send();

endView(); // 查看运行时间和内存


