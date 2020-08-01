<?php


$router->get('/',function (){
    return "web:hello world";
})->middleware(\core\middleware\IsAuthLoginMIddleware::class);


$router->group([
    'prefix' => 'group1'
],function($router){
    $router->get('/',function (){
        return 'web:group1:hello world';
    });
});