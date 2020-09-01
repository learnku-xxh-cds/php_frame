<?php


namespace core;
use Throwable;
class HandleExceptions
{

    // 要忽略记录的异常
    protected $ignore = [


    ];

    public function init()
    {
        // 所有异常到托管到handleException方法
        set_exception_handler([$this, 'handleException']);
    }

    // 异常托管到这个方法
    public function handleException(Throwable $e)
    {

        \App::getContainer()->get('response')->setContent(
            $e->render()
        )->send();

        if( $this->isIgnore($e))
         return;

        // 系统操作

    }

    // 是否忽略异常
    protected function isIgnore(Throwable $e)
    {
        foreach ($this->ignore as $item)
            if( $item instanceof  $e)
                return true;
        return false;
    }


}