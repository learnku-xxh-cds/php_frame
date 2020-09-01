<?php


namespace core\log;



use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;


class LoggerSet
{
    use LoggerAwareTrait;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    // 代理模式
    public function __call($name, $arguments)
    {
        $this->logger($name, ...$arguments);
    }
}