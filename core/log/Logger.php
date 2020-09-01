<?php


namespace core\log;

use core\log\driver\DailyLogger;
use core\log\driver\StackLogger;

class Logger
{

    protected $channels = []; // 所有的通道

    protected $config;
    public function __construct()
    {
        $this->config = config('log');
    }

    public function channel($name = null)
    {

        if(! $name)
            $name = $this->config['default'];


        if( isset($this->channels[$name]))
            return $this->channels[$name];

        $config = config('log.channels.'.$name);

        //如:$config['driver'] = stack, 则调用createStack($config);
        return $this->channels['name'] = $this->{'create'.ucfirst($config['driver'])}($config);
    }


    // 放在同一个文件
    public function createStack($config)
    {
        return new StackLogger($config);
    }

    // 按日期
    public function createDaily($config)
    {
        return new DailyLogger($config);
    }


    public function __call($method, $parameters)
    {
        return $this->channel()->$method(...$parameters);
    }

}