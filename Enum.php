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
}
