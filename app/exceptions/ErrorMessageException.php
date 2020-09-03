<?php

namespace App\exceptions;
use Exception;
// 错误消息返回
class ErrorMessageException extends  Exception
{
    public function render()
    {
        return  [
            'data' => $this->getMessage(),
            'code' => 400
        ];
    }
}