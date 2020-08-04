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
    return App::get('db')->table('users')->get();
    //return \App::get('db')->select('select * from users');
});
