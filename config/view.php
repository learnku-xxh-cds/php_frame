<?php

return [
    // 使用那个模板引擎
    'engine' =>  \core\view\Blade::class,

    // 模板缓存路径
    'cache_path' => FRAME_BASE_PATH . 'views/cache',

    // 模板的根目录
    'view_path' => FRAME_BASE_PATH . 'views/'

];