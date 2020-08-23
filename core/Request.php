<?php
namespace core;


class Request
{


    public function __construct(array $server,$method,$uri,$queryParams,$postParams,array $header)
    {

    }

    public static function init($server)
    {
        return new self($server->server,$server->server['request_method'],$server->server['request_uri'],$server->server['query_string']??0,$server->post,
            $server->header,$server->tmpfiles);
    }


}