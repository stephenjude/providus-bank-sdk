<?php

declare(strict_types=1);

namespace Providus;

class Enum
{
    public const METHOD_POST = 'post';
    public const METHOD_GET = 'get';

    public const STATUS_CODE_SUCCESS = '00';
    public const STATUS_CODE_DUPLICATE = '01';
    public const STATUS_CODE_REJECTED = '02';

    public const STATUS_TEXT_SUCCESS = 'success';
    public const STATUS_TEXT_DUPLICATE = 'duplicate transaction';
    public const STATUS_TEXT_REJECTED = 'rejected transaction';

    public const REQUIRED_HEADER_CLIENT_ID = 'HTTP_CLIENT_ID';
    public const REQUIRED_HEADER_AUTH_SIGNATURE = 'HTTP_X_AUTH_SIGNATURE';

    public const REQUIRED_FIELD_SESSION_ID = 'sessionId';
    public const REQUIRED_FIELD_ACCOUNT_NUMBER = "accountNumber";
    public const REQUIRED_FIELD_REMARK = "tranRemarks";
    public const REQUIRED_FIELD_AMOUNT = "transactionAmount";
    public const REQUIRED_FIELD_SETTLED_AMOUNT = "settledAmount";
    public const REQUIRED_FIELD_FEE_AMOUNT = "feeAmount";
    public const REQUIRED_FIELD_VAT_AMOUNT = "vatAmount";
    public const REQUIRED_FIELD_CURRENCY = "currency";
    public const REQUIRED_FIELD_TRANSACTION_REFERENCE = "initiationTranRef";
    public const REQUIRED_FIELD_SETTLEMENT_ID = "settlementId";
    public const REQUIRED_FIELD_SOURCE_ACCOUNT_NUMBER = "sourceAccountNumber";
    public const REQUIRED_FIELD_SOURCE_ACCOUNT_NAME = "sourceAccountName";
    public const REQUIRED_FIELD_SOURCE_BANK_NAME = "sourceBankName";
    public const REQUIRED_FIELD_CHANNEL_ID = "channelId";
    public const REQUIRED_FIELD_TRANSACTION_DATE = "tranDateTime";
}
