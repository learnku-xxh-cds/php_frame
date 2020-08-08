<?php


// 路由 中间件已完善
$router->get('/',function (){
    return "web:hello world";
})->middleware(\App\Middleware\IsAuthMiddleWare::class);


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
   return App::get('config')->get('database.default');
});

// TODO 查询构造器 增删改查 连表 都还完善
$router->get('database',function (){
    // 代理模式大小写可以忽略的
    return App::get('db')->TABLE('users')->GET();
    return App::get('db')->table('users')->where('id',54545464646)->ORWHERE('id',4)
        ->Orwhere('id',1)->GET('id','nickname');
    // return App::get('db')->TABLE('users')->WHERE('id',54545464646)->ORWHERE('id',4)->GET('id','nickname');
    //return \App::get('db')->select('select * from users');
});

// TODO 模型层还有很多可以完善 比如 修改器 访问器 模型事件 转换器 模型关联 等等超多
$router->get('model',function (){
 $users = \App\Models\User::Where('id',1)->orWhere('id',2)->get();
 foreach ($users as $user)
    echo $user->sayPhp()."<br/>";

});



// 完成
$router->get('controller', 'UserController@index');


// v 视图
$router->get('controller', 'UserController@view');
