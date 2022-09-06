<?php

declare(strict_types=1);

namespace Providus;

class HttpResponse
{
    private string $response;

    private array $requestInfo;

    function __construct(string $response, array $requestInfo)
    {
        $this->requestInfo = $requestInfo;

        $this->response = $response;
    }

    function body(): string
    {
        return $this->response;
    }

    function json(): array
    {
        return json_decode($this->response, true, 512, JSON_THROW_ON_ERROR);
    }

    function status(): int
    {
        return $this->requestInfo['http_code'];
    }

    function isSuccess(): bool
    {
        return $this->status() >= 200 && $this->status() < 300;
    }

    function isOk(): bool
    {
        return $this->isSuccess();
    }

    function isRedirect(): bool
    {
        return $this->status() >= 300 && $this->status() < 400;
    }

    function isClientError(): bool
    {
        return $this->status() >= 400 && $this->status() < 500;
    }

    function isServerError(): bool
    {
        return $this->status() >= 500;
    }
}
