<?php

declare(strict_types=1);

namespace Providus\Http;

require_once __DIR__.'/../Enum.php';
require_once __DIR__.'/Response.php';
require_once __DIR__.'/ApiException.php';

use Providus\Enum;
use Providus\Http\Response;
use Providus\Http\ApiException;

class Request
{
    private $client;
    private $fakeClient = false;
    private string $clientId;
    private string $clientSecret;
    private string $baseUrl;

    public function __construct(string $clientId, string $clientSecret, string $baseUrl)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->baseUrl = $baseUrl;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function createAuthSignature()
    {
        if ($this->fakeClient) {
            return 'BE09BEE831CF262226B426E39BD1092AF84DC63076D4174FAC78A2261F9A3D6E59744983B8326B69CDF2963FE314DFC89635CFA37A40596508DD6EAAB09402C7';
        }

        return hash('sha512', $this->clientSecret);
    }

    public function fakeClient(): Request
    {
        $this->fakeClient = true;

        return $this;
    }

    public function isFakeClient(): bool
    {
        return $this->fakeClient;
    }


    public function method(string $method = 'get'): Request
    {
        switch (strtolower($method)) {
            case Enum::METHOD_POST:
                curl_setopt($this->client, CURLOPT_POST, true);
                break;
            default:
        }

        return $this;
    }

    public function path(string $path): Request
    {
        $apiUrl = $this->baseUrl.$path;

        curl_setopt($this->client, CURLOPT_URL, $apiUrl);

        return $this;
    }

    public function headers(array $headers = []): Request
    {
        $headers = array_merge_recursive($headers, [
            'Client-Id' => $this->clientId,
            'X-Auth-Signature' => $this->createAuthSignature(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);

        $headers = array_map(fn($key, $value) => "$key: $value", array_keys($headers), array_values($headers));

        curl_setopt($this->client, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($this->client, CURLOPT_RETURNTRANSFER, true);

        return $this;
    }

    public function body(array $data = []): Request
    {
        if (!empty($data)) {
            curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($data, JSON_THROW_ON_ERROR));
        }

        return $this;
    }

    public function send(string $method, string $path, array $body = [], array $headers = []): Response
    {
        $this->client = curl_init();

        $this->path($path)->headers($headers)->method($method)->body($body);

        $response = curl_exec($this->client);

        $requestInfo = curl_getinfo($this->client);

        if ($response === false) {
            throw new ApiException("CURL server error", 500);
        }

        curl_close($this->client);

        return new Response($response, $requestInfo);
    }
}
