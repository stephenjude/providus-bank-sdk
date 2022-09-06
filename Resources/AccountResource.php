<?php
declare(strict_types=1);

namespace Providus\Resources;

class AccountResource
{
    public string $accountNumber;
    public string $accountName;
    public ?string $bvn;

    public function __construct(array $data)
    {
        $this->accountNumber = $data['account_number'];
        $this->accountName = $data['account_name'];
        $this->bvn = $data['bvn'] ?? null;
    }
}
