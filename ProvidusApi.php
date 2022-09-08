<?php

declare(strict_types=1);

namespace Providus;

require_once __DIR__.'/Http/Request.php';
require_once __DIR__.'/Http/ApiException.php';
require_once __DIR__.'/Resources/AccountResource.php';
require_once __DIR__.'/Resources/TransactionResource.php';

use Providus\Http\Request;
use Providus\Http\ApiException;
use Providus\Resources\AccountResource;
use Providus\Resources\TransactionResource;

class ProvidusApi
{
    private Request $request;

    public function __construct()
    {
        $this->request = new Request(
            'dGVzdF9Qcm92aWR1cw==',
            '29A492021F4B709A8D1152C3EF4D32DC5A7092723ECAC4C511781003584B48873CCBFEBDEAE89CF22ED1CB1A836213549BC6638A3B563CA7FC009BEB3BC30CF8',
            'http://154.113.16.142:8088/AppDevAPI/api/',
        );

        // $this->request->fakeClient(); // This is used to toggle the development auth signature;
    }

    /**
     * @param  string  $name
     * @param  string  $bvn
     * @return AccountResource
     * @throws ApiException
     */
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
            throw new ApiException($response->reason(), $response->status());
        }

        if (empty($response->json()['accountName'])) {
            throw new ApiException($response->json()['responseMessage']);
        }

        return new AccountResource($response->json());
    }

    /**
     * @param  string  $name
     * @return AccountResource
     * @throws ApiException
     */
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
            throw new ApiException();
        }

        if (empty($response->json()['accountName'])) {
            throw new ApiException($response->json()['responseMessage']);
        }

        return new AccountResource($response->json());
    }

    /**
     * @param  string  $name
     * @param  string  $number
     * @return array
     * @throws ApiException
     */
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
            throw new ApiException();
        }

        if (empty($response->json()['accountName'])) {
            throw new ApiException($response->json()['responseMessage']);
        }

        return $response->json();
    }

    /**
     * @param  string  $number
     * @return array
     * @throws ApiException
     */
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
            throw new ApiException();
        }

        return $response->json();
    }

    /**
     * @param  string  $sessionId
     * @return TransactionResource
     * @throws ApiException
     */
    public function verifyTransactionBySessionId(string $sessionId): TransactionResource
    {
        $response = $this->request->send(
            Enum::METHOD_GET,
            "PiPverifyTransaction?session_id=$sessionId",
        );

        if ($response->isSuccess() === false) {
            throw new ApiException();
        }

        if (empty($response->json()['sessionId'])) {
            throw new ApiException($response->json()['tranRemarks']);
        }

        return new TransactionResource($response->json());
    }

    /**
     * @param  string  $settlementId
     * @return TransactionResource
     * @throws ApiException
     */
    public function verifyTransactionBySettlementId(string $settlementId): TransactionResource
    {
        $response = $this->request->send(
            Enum::METHOD_GET,
            "PiPverifyTransaction?settlement_id=$settlementId",
        );

        if ($response->isSuccess() === false) {
            throw new ApiException();
        }

        if (empty($response->json()['settlementId'])) {
            throw new ApiException($response->json()['tranRemarks']);
        }

        return new TransactionResource($response->json());
    }
}
