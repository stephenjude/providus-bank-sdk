<?php

declare(strict_types=1);

namespace Providus;

class HttpResponse
{
    private $response;

    function __construct($response)
    {
        $this->response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }

    function body()
    {
        return (string)$this->response['body'];
    }

    function json()
    {
        return json_decode($this->response['body'], true, 512, JSON_THROW_ON_ERROR);
    }

    function header($header)
    {
        return $this->headers()[$header];
    }

    function headers()
    {
        return $this->response['headers'];
    }

    function status()
    {
        return $this->response['status'];
    }

    function isSuccess()
    {
        return $this->status() >= 200 && $this->status() < 300;
    }

    function isOk()
    {
        return $this->isSuccess();
    }

    function isRedirect()
    {
        return $this->status() >= 300 && $this->status() < 400;
    }

    function isClientError()
    {
        return $this->status() >= 400 && $this->status() < 500;
    }

    function isServerError()
    {
        return $this->status() >= 500;
    }
}
