<?php




// 开发期间 显示所有错误
error_reporting(E_ALL);
ini_set("display_errors","On");

require_once  __DIR__ . '/../vendor/autoload.php'; // 引入自动加载
require_once __DIR__ . '/../app.php';   // 框架的文件






App::getContainer()->get('response')->setContent( // 响应
    App::getContainer()->get('route')->dispatch( // 路由
       App::getContainer()->get(\core\request\RequestInterface::class)
    )
)->send();

endView(); // 查看运行时间和内存


