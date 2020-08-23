<?php


namespace core\request;

interface RequestInterface
{
    public static function init();

    public static function create();

    public function getUri();

    public function getMethod();

    public function getHeader();

}