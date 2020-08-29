<?php

namespace core\request;

class PhpRequest implements RequestInterface
{


    protected $url;
    protected $method;
    protected $headers;
    public function __construct($uri,$method,$headers)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->headers = $headers;
    }

    public static function create($uri,$method,$headers = [])
    {
        return new static($uri, $method, $headers);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getHeader()
    {

    }


}