<?php

declare(strict_types=1);

namespace Providus\Http;

require_once __DIR__.'/../Enum.php';

use Providus\Enum;

class Response
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

    function json(): ?array
    {
        return json_decode($this->response, true);
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

    public function providusStatus(): ?string
    {
        return $this->json()['responseCode'] ?? '';
    }

    public function providusMessage(): ?string
    {
        return $this->json()['responseMessage'] ?? '';
    }

    public function reason(): ?string
    {
        return $this->providusMessage();
    }
}
