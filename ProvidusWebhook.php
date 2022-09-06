<?php

declare(strict_types=1);

namespace Providus;

require_once __DIR__.'/ProvidusApi.php';

use Providus\ProvidusApi;

class ProvidusWebhook
{
    public function verifyTransaction(string $sessionId): array
    {
        try {
            $providus = new ProvidusApi();

            $transaction = $providus->verifyTransactionBySessionId($sessionId);

            return $this->buildResponse($sessionId, Enum::STATUS_CODE_SUCCESS);
        } catch (\Exception $exception) {
            return $this->buildResponse($sessionId, Enum::STATUS_CODE_REJECTED);
        }
    }

    private function buildResponse(string $sessionId, string $status): array
    {
        switch ($status) {
            case Enum::STATUS_CODE_DUPLICATE:
                $statusCode = Enum::STATUS_CODE_DUPLICATE;
                $statusText = Enum::STATUS_TEXT_DUPLICATE;
                break;
            case Enum::STATUS_CODE_REJECTED:
                $statusCode = Enum::STATUS_CODE_REJECTED;
                $statusText = Enum::STATUS_TEXT_REJECTED;
                break;
            default:
                $statusCode = Enum::STATUS_CODE_SUCCESS;
                $statusText = Enum::STATUS_TEXT_SUCCESS;
        }

        return [
            "requestSuccessful" => true,
            "sessionId" => $sessionId,
            "responseMessage" => $statusText,
            "responseCode" => $statusCode,
        ];
    }
}
