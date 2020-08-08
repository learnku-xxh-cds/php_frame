<?php


// visit /
$router->get('/',function (){
    return "web:hello world";
})->middleware(\App\Middleware\IsAuthMiddleWare::class);



$router->group([
    'prefix' => 'group',
    'middleware' => \App\Middleware\IsAuthMiddleWare::class
],function($router){

    // visit /group1/
    $router->get('/',function (){
        return 'web:group1:hello world';
    });
});

// 配置
$router->get('config',function (){
   return App::get('config')->get('database.default');
});

// 查询构造器
$router->get('database',function (){

    // 代理模式大小写可以忽略的
    return App::get('db')->TABLE('users')->GET();


    return App::get('db')->table('users')->where('id',54545464646)->ORWHERE('id',4)
        ->Orwhere('id',1)->GET('id','nickname');
    // return App::get('db')->TABLE('users')->WHERE('id',54545464646)->ORWHERE('id',4)->GET('id','nickname');
    //return \App::get('db')->select('select * from users');
});

// 模型
$router->get('model',function (){
 $users = \App\Models\User::Where('id',1)->orWhere('id',2)->get();
 foreach ($users as $user){
    echo $user->sayPhp()."<br/>";
 }
});


