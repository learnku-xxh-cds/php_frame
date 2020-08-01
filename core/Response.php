<?php


namespace core;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface
{

    protected $headers = [];
    protected $content = '';

    public function sendContent()
    {
        echo $this->content;
    }

    public function sendHeaders()
    {

        foreach ($this->headers as $key => $header)
        header($key.': '.$header);

    }
    protected function initBaseHeaders()
    {
        $this->headers['Date'] = date();
        $this->headers['Cache-Control'] = 'no-cache, private';
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }


    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
        $this->headers[$name] = $value;
        return $this;
    }


    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
        return $this->headers[$name] ?? null;
    }


    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }


    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }



    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function getStatusCode()
    {
        // TODO: Implement getStatusCode() method.
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        // TODO: Implement withStatus() method.
    }

    public function getReasonPhrase()
    {
        // TODO: Implement getReasonPhrase() method.
    }
}