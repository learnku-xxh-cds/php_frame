<?php

$router->get('/',function (){
    return "api:hello world";
});


$router->group([
    'prefix' => 'group1'
],function($router){
    $router->get('/',function (){
        return 'api:group1:hello world';
    });
});