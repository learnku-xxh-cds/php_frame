<?php


// 路由 中间件已完善
$router->get('/',function (){
    return 1;
    return "web:hello world";
})->middleware(\App\Middleware\IsAuthMiddleWare::class);

$router->post('/',function (){
   return 'post';
});

// 路由组已完善
$router->group([
    'prefix' => 'group',
    'middleware' => \App\Middleware\IsAuthMiddleWare::class
],function($router){
    $router->get('/',function (){
        return 'web:group1:hello world';
    });
});

// TODO 配置设置未完善
$router->get('config',function (){
   return App::getContainer()->get('config')->get('database.default');
});

// TODO 查询构造器 增删改查 连表 都还完善
$router->get('database',function (){
    // 代理模式大小写可以忽略的
    return App::getContainer()->get('db')->TABLE('users')->GET();
    return App::getContainer()->get('db')->table('users')->where('id',54545464646)->ORWHERE('id',4)
        ->Orwhere('id',1)->GET('id','nickname');
    // return App::getContainer()->get('db')->TABLE('users')->WHERE('id',54545464646)->ORWHERE('id',4)->GET('id','nickname');
    //return \App::getContainer()->get('db')->select('select * from users');
});

// TODO 模型层还有很多可以完善 比如 修改器 访问器 模型事件 转换器 模型关联 等等超多
$router->get('model',function (){
 $users = \App\Models\User::Where('id',1)->orWhere('id',2)->get();
 foreach ($users as $user)
    echo $user->sayPhp()."<br/>";

});



// 完成
$router->get('controller', 'UserController@index');



// blade的模板引擎 默认使用
$router->get('view/blade', function (){
    $str = '这是blade模板引擎';
    return App::getContainer()->get(\core\view\ViewInterface::class)->render('blade.index',compact('str'));
});

// tp的模板引擎
$router->get('view/thinkphp', function (){
    App::getContainer()->get('config')->set('view.engine',\core\view\Thinkphp::class); // 修改配置为tp的
    App::getContainer()->get('view')->init(); // 重新初始化

    $str = '这是thinkphp模板引擎';
    return App::getContainer()->get('view')->render('thinkphp.index',compact('str'));
});




$router->get('exception',function (){
    // 服务器不想鸟你并抛出了异常
   throw new \App\exceptions\ErrorMessageException('The server did not want to bird you and threw an exception');
});

$router->get('error',function (){
    helloworld; // 故意弄错 让它记录到日志
});


// 完成
$router->get('log', function (){
 //   app('log')->info(['user_' => 1],['language' => 'php']);
  app('log')->info('{language} is the best language in the world',['language' => 'php']);
    app('log')->channel('file2')->info('{language} is the best language in the world',['language' => 'php']);
});
