<?php

namespace core\view;

interface ViewInterface
{

    // 初始化模板
    public function init();


    // 解析模板模板
    function render($path);

}