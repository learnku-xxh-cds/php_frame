<?php


namespace core\request;

interface RequestInterface
{
    public function __construct($uri,$method,$headers); // 初始化

    public static function create($uri,$method,$headers); // 创建request对象

    public function getUri(); // 获取请求url

    public function getMethod(); // 获取请求方法

    public function getHeader(); // 获取请求头


}