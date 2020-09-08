<?php


// 开发期间 显示所有错误
use core\request\PhpRequest;

error_reporting(E_ALL);
ini_set("display_errors","On");


require_once  __DIR__ . '/vendor/autoload.php'; // 引入自动加载
require_once __DIR__ . '/app.php';   // 框架的文件



$start = function()
{
    // Swoole\Runtime::enableCoroutine($flags = SWOOLE_HOOK_ALL);
    $http = new Swoole\Http\Server('0.0.0.0', 9501);
    $http->set([
        'pid_file' => FRAME_BASE_PATH.'/storage/swoole.pid',
        'enable_coroutine' => true,
        'worker_num' => 4
    ]);

    // 绑定request
    app()->bind(\core\request\RequestInterface::class,function () {
        return \core\SwooleContext::get('request');
    },false);

    $http->on('request', function ($request, $response) {
        $server = $request->server;
        \core\SwooleContext::put('request',PhpRequest::create(
            $server['path_info'],
            $server['request_method'],
            $server
        ));

        $response->end(
            app('response')->setContent( // 响应
                app('route')->dispatch( // 路由
                    app(\core\request\RequestInterface::class) // 请求
                    // 其实是调用\core\SwooleContext::get('request')
                )
            )->getContent()
        );
        \core\SwooleContext::delete(); // 释放内存
    });

    $http->start();
};

$stop = function ()
{

    if(! file_exists(FRAME_BASE_PATH.'/storage/swoole.pid'))
        return;
    $pid = file_get_contents(FRAME_BASE_PATH.'/storage/swoole.pid');
    Swoole\Process::kill($pid);
};




$reload = function ()
{

};


$handle = $argv[1];

if( $handle == 'start')
    $start();

elseif( $handle == 'stop');
    $stop();


