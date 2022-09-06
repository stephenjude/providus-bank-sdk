<?php

declare(strict_types=1);

namespace Providus\Resources;

class TransactionResource
{
    public string $sessionId;
    public string $initiationTransactionReference;
    public string $accountNumber;
    public string $remarks;
    public string $transactionAmount;
    public string $settledAmount;
    public string $feeAmount;
    public string $vatAmount;
    public string $currency;
    public string $settlementId;
    public string $sourceAccountNumber;
    public string $sourceAccountName;
    public string $sourceBankName;
    public string $channelId;
    public string $transactionDate;

    public function __construct(array $data)
    {
        $this->sessionId = $data['sessionId'];
        $this->initiationTransactionReference = $data['initiationTranRef'];
        $this->accountNumber = $data['accountNumber'];
        $this->remarks = $data['tranRemarks'];
        $this->transactionAmount = $data['transactionAmount'];
        $this->settledAmount = $data['settledAmount'];
        $this->feeAmount = $data['feeAmount'];
        $this->vatAmount = $data['vatAmount'];
        $this->currency = $data['currency'];
        $this->settlementId = $data['settlementId'];
        $this->sourceAccountNumber = $data['sourceAccountNumber'];
        $this->sourceAccountName = $data['sourceAccountName'];
        $this->sourceBankName = $data['sourceBankName'];
        $this->channelId = $data['channelId'];
        $this->transactionDate = $data['tranDateTime'];
    }
}
