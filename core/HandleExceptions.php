<?php


namespace core;
use App\exceptions\ErrorMessageException;
use App\exceptions\RunErrorException;
use Throwable;
class HandleExceptions
{


    // 要忽略记录的异常 不记录到日志去
    protected $ignore = [

    ];
    public function init()
    {

        // 所有异常到托管到handleException方法
      set_exception_handler([$this, 'handleException']);

        // 所有错误到托管到handleErorr方法
        set_error_handler([$this,'handleErorr']);
    }


    // 见:https://www.runoob.com/php/php-error.html
    public function handleErorr($error_level, $error_message, $error_file,$error_line,$error_context)
    {
        app('response')->setContent(
            '死机 都死机 自动开机 关机 重启再死机 三星手机 苹果手机 所有都死机 全世界只剩小米.....'
        )->setCode(500)->send();

        // 记录到日志
        app('log')->error(
            $error_message.' at '.$error_file.':'.$error_file
        );
    }

    // 异常托管到这个方法
    public function handleException(Throwable $e)
    {

        if( method_exists($e,'render'))
        app('response')->setContent(
            $e->render()
        )->send();


        if(! $this->isIgnore($e)){ // 不忽略 记录异常到日志去
            app('log')->debug(
                $e->getMessage().' at '.$e->getFile().':'.$e->getLine()
            );
        }
    }

    // 是否忽略异常
    protected function isIgnore(Throwable $e)
    {
        foreach ($this->ignore as $item)
            if( $item ==  get_class($e))
                return true;
        return false;
    }


}