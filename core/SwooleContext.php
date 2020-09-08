<?php


namespace core;

use Swoole\Coroutine;

// 见文档: https://wiki.swoole.com/#/coroutine/notice?id=%e6%ad%a3%e7%a1%ae%e7%a4%ba%e4%be%8b%ef%bc%9a%e4%bd%bf%e7%94%a8context%e7%ae%a1%e7%90%86%e4%b8%8a%e4%b8%8b%e6%96%87
class SwooleContext
{
    protected static $pool = [];

    static function get($key)
    {
        $cid = Coroutine::getuid();
        if ($cid < 0)
        {
            return null;
        }
        if(isset(self::$pool[$cid][$key])){
            return self::$pool[$cid][$key];
        }
        return null;
    }

    static function put($key, $item)
    {
        $cid = Coroutine::getuid();
        if ($cid > 0)
        {
            self::$pool[$cid][$key] = $item;
        }

    }

    static function delete($key = null)
    {
        $cid = Coroutine::getuid();
        if ($cid > 0)
        {
            if($key){
                unset(self::$pool[$cid][$key]);
            }else{
                unset(self::$pool[$cid]);
            }
        }
    }

}