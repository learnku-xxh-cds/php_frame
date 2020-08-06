<?php


// visit /
$router->get('/',function (){
    return "web:hello world";
})->middleware(\core\middleware\IsAuthLoginMIddleware::class);



$router->group([
    'prefix' => 'group1'
],function($router){

    // visit /group1/
    $router->get('/',function (){
        return 'web:group1:hello world';
    });
});



// visit /config
$router->get('config',function (){
   return App::get('config')->get('database.default');
});


$router->get('database',function (){

    return App::get('db')->table('users')->Find(1);

    return App::get('db')->table('users')->where('id',54545464646)->ORWHERE('id',4)
        ->Orwhere('id',1)->GET('id','nickname');
    // return App::get('db')->TABLE('users')->WHERE('id',54545464646)->ORWHERE('id',4)->GET('id','nickname');
    //return \App::get('db')->select('select * from users');
});


$router->get('model',function (){
//   return \App\Models\User::Where('id',1)->orWhere('id',2)->get();
});