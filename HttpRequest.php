<?php

declare(strict_types=1);

namespace Providus;

require_once __DIR__.'/Enum.php' ;
require_once __DIR__.'/HttpResponse.php';
require_once __DIR__.'/HttpException.php';

use Providus\Enum;
use Providus\HttpResponse;
use Providus\HttpException;

class HttpRequest
{
    public $client;
    public string $clientId;
    public string $clientSecret;
    public string $baseUrl;

    public function __construct(
        string $clientId,
        string $clientSecret,
        $baseUrl = 'http://154.113.16.142:8088/appdevapi/'
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->baseUrl = $baseUrl;
    }

    public function createAuthSignature()
    {
        return hash('sha512', $this->clientSecret);
    }

    public function method(string $method = 'get'): HttpRequest
    {
        switch (strtolower($method)) {
            case Enum::METHOD_POST:
                curl_setopt($this->client, CURLOPT_POST, true);
                break;
            default:
        }

        return $this;
    }

    public function path(string $path): HttpRequest
    {
        curl_setopt($this->client, CURLOPT_URL, urlencode($this->baseUrl.$path));

        return $this;
    }

    public function headers(array $headers = []): HttpRequest
    {
        $headers = array_merge_recursive($headers, [
            'Client-Id' => $this->clientId,
            'X-Auth-Signature' => $this->createAuthSignature(),
            'Content-Type' => 'application/json',
            'Accepts' => 'application/json',
        ]);

        $headers = array_map(fn($key, $value) => "$key: $value", array_keys($headers), array_values($headers));

        curl_setopt($this->client, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($this->client, CURLOPT_RETURNTRANSFER, true);

        return $this;
    }

    public function body(array $data = []): HttpRequest
    {
        if (!empty($data)) {
            curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($data, JSON_THROW_ON_ERROR));
        }

        return $this;
    }

    public function send(string $method, string $path, array $body = [], array $headers = []): HttpResponse
    {
        $this->client = curl_init();

        $this->headers($headers)->method($method)->path($path)->body($body);

        $response = curl_exec($this->client);

        if ($response === false) {
            throw new HttpException(curl_error($this->client), curl_errno($this->client));
        }

        curl_close($this->client);

        return new HttpResponse($response);
    }
}
