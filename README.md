# providus-bank-sdk
This package is used for consuming providus bank apis.

## Usage
Initiailize the Providus API
```php
require_once __DIR__.'/ProvidusApi.php';

$bank = new \Providus\ProvidusApi();
```
### Creating dynamic account number:
```php
$accountDetails = $bank->createDynamicAccountNumber('customer_name');
$accountDetails->accountName;
$accountDetails->accountNumber;
```
### Creating reserved account number:
```php
$accountDetails =  $bank->createReservedAccountNumber('customer_name', 'customer_bvn');
$accountDetails->accountName;
$accountDetails->accountNumber;
$accountDetails->bvn;
```
### Updating account name:
```php
$accountDetails = $bank->updateAccountName('customer_updated_name', 'customer_account_number');
$accountDetails->accountName;
$accountDetails->accountNumber;
```

### Blacklisting account number:
```php
$bank->blacklistAccountNumber('customer_account_number');
```

### Verifying transaction using session or settlement ID:

```php
$transaction = $bank->verifyTransactionBySessionId('session_id');

$transaction =  $bank->verifyTransactionBySettlementId('settlement_id');

$transaction->sessionId;
$transaction->settlementId;
$transaction->accountNumber;
$transaction->currency;
$transaction->transactionAmount;
$transaction->transactionReference;
$transaction->transactionDate;
$transaction->feeAmount;
$transaction->settledAmount;
$transaction->sourceAccountNumber;
$transaction->sourceAccountNumber;
$transaction->sourceBankName;
$transaction->remarks;
$transaction->channelId;
```
