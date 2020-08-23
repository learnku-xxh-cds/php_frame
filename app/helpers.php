<?php

function response()
{
    return App::getContainer()->getApp('response');
}


function app($name)
{
    return App::getContainer()->get($name);
}

function endView()
{
    $time = microtime(true) - FRAME_START_TIME;
    $memory = memory_get_usage() - FRAME_START_MEMORY;

    echo '<br/><br/><br/><br/><br/><hr/>';
    echo "运行时间: ". round($time * 1000,2) .'ms<br/>';
    echo "消耗内存: ". round($memory / 1024 / 1024,2) . 'm';
}