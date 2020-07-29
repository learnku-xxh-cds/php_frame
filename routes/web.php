<?php


$router->get('/',function (){
    return "web:hello world";
});


$router->group([
    'prefix' => 'group1'
],function($router){
    $router->get('/',function (){
        return 'web:group1:hello world';
    });
});