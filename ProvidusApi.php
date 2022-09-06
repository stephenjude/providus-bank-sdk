<?php

declare(strict_types=1);

namespace Providus;

require __DIR__.'/Http/Request.php';
require __DIR__.'/Resources/AccountResource.php';
require __DIR__.'/Resources/TransactionResource.php';

use Providus\Http\Request;
use Providus\Resources\AccountResource;
use Providus\Resources\TransactionResource;

class ProvidusApi
{
    private $request;

    public function __construct()
    {
        $this->request = new Request(
            'dGVzdF9Qcm92aWR1cw==',
            '29A492021F4B709A8D1152C3EF4D32DC5A7092723ECAC4C511781003584B48873CCBFEBDEAE89CF22ED1CB1A836213549BC6638A3B563CA7FC009BEB3BC30CF8',
            'http://154.113.16.142:8088/AppDevAPI/api/',
        );
    }

    public function createReservedAccountNumber(string $name, string $bvn): AccountResource
    {
        $requestData = [
            'account_name' => $name,
            'bvn' => $bvn,
        ];

        $response = $this->request->send(
            Enum::METHOD_POST,
            'PiPCreateReservedAccountNumber',
            $requestData
        );

        if ($response->isSuccess() === false) {
            throw new HttpException($response->reason(), $response->status());
        }

        return new AccountResource($response->json());
    }

    public function createDynamicAccountNumber(string $name): AccountResource
    {
        $requestData = [
            'account_name' => $name,
        ];

        $response = $this->request->send(
            Enum::METHOD_POST,
            'PiPCreateDynamicAccountNumber',
            $requestData
        );

        if ($response->isSuccess() === false) {
            throw new HttpException($response->reason(), $response->status());
        }

        return new AccountResource($response->json());
    }

    public function updateAccountName(string $name, string $number): array
    {
        $requestData = [
            'account_number' => $number,
            'account_name' => $name,
        ];

        $response = $this->request->send(
            Enum::METHOD_POST,
            'PiPUpdateAccountName',
            $requestData
        );

        if ($response->isSuccess() === false) {
            throw new HttpException($response->reason(), $response->status());
        }

        return $response->json();
    }

    public function blacklistAccountNumber(string $number): array
    {
        $requestData = [
            'account_number' => $number,
            'blacklist_flg' => 1,
        ];

        $response = $this->request->send(
            Enum::METHOD_POST,
            'PiPBlacklistAccount',
            $requestData
        );

        if ($response->isSuccess() === false) {
            throw new HttpException($response->reason(), $response->status());
        }

        return $response->json();
    }

    public function verifyTransactionBySessionId(string $sessionId): TransactionResource
    {
        $response = $this->request->send(
            Enum::METHOD_GET,
            "PiPverifyTransaction?session_id=$sessionId",
        );

        if ($response->isSuccess() === false) {
            throw new HttpException($response->reason(), $response->status());
        }

        return new TransactionResource($response->json());
    }

    public function verifyTransactionBySettlementId(string $settlementId): TransactionResource
    {
        $response = $this->request->send(
            Enum::METHOD_GET,
            "PiPverifyTransaction?settlement_id=$settlementId",
        );

        if ($response->isSuccess() === false) {
            throw new HttpException($response->reason(), $response->status());
        }

        return new TransactionResource($response->json());
    }
}
