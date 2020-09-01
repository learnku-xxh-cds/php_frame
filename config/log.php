<?php

return [
    'default' => 'file1',
    'level' =>[],
    'channels' => [
        'file1' => [ // 文件类型的日志
            'driver' => 'stack',
            'path' => FRAME_BASE_PATH.'/storage/',
            'format' => '[%s][%s] %s', // 格式化类型  分别代表:[日期][日志级别]消息
        ],
        'file2' => [
            'driver' => 'daily',
            'path' => FRAME_BASE_PATH.'/storage/',
            'format' => '[%s][%s] %s', // 格式化类型
        ]

    ]

];