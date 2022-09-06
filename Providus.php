<?php

class ENUM
{
    public const METHOD_POST = 'post';
    public const METHOD_GET = 'get';
}

class PendingRequest
{
    public $client;
    public string $clientId;
    public string $clientSecret;
    public string $baseUrl;

    public function __construct(
        string $clientId,
        string $clientSecret,
        $baseUrl = ' http://154.113.16.142:8088/appdevapi/api/'
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->baseUrl = $baseUrl;
    }

    public function createAuthSignature()
    {
        return hash('sha512', $this->clientSecret);
    }

    public function method(string $method = 'get'): PendingRequest
    {
        switch (strtolower($method)) {
            case ENUM::METHOD_POST:
                curl_setopt($this->client, CURLOPT_POST, true);
                break;
            default:
        }

        return $this;
    }

    public function path(string $path): PendingRequest
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->baseUrl.$url);

        return $this;
    }

    public function headers(array $headers = []): PendingRequest
    {
        $headers = array_merge_recursive($headers, [
            'Client-Id' => $this->clientId,
            'X-Auth-Signature' => $this->createAuthSignature(),
            'Content-Type' => 'application/json',
            'Accepts' => 'application/json',
        ]);

        $headers = array_values(array_map(fn($value, $key) => "$key:$value", $headers));

        curl_setopt($this->client, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($this->client, CURLOPT_RETURNTRANSFER, true);

        return $this;
    }

    public function body(array $data = []): PendingRequest
    {
        if (!empty($data)) {
            curl_setopt($this->client, CURLOPT_POSTFIELDS, json_encode($data, JSON_THROW_ON_ERROR));
        }

        return $this;
    }

    public function send(string $method, string $path, array $body = [], array $headers = []): Response
    {
        try {
            $this->client = curl_init();

            $this->headers($headers);

            $this->method($method);

            $this->path($path);

            $this->body($body);

           $response = curl_exec($this->client);

            curl_close($this->client);

            return new Response($response);
        } catch (Exception $exception) {
            throw new ConnectionException($exception);
        }
    }
}

class Response
{
    private $response;

    function __construct($response)
    {
        $this->response = json_decode($response);
    }

    function body()
    {
        return (string)$this->response->getBody();
    }

    function json()
    {
        return json_decode($this->response->getBody(), true);
    }

    function header($header)
    {
        return $this->response->getHeaderLine($header);
    }

    function headers()
    {
        return collect($this->response->getHeaders())->mapWithKeys(function ($v, $k) {
            return [$k => $v[0]];
        })->all();
    }

    function status()
    {
        return $this->response->getStatusCode();
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

class ConnectionException extends \Exception
{
}

class Providus extends PendingRequest
{

}

