<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Account extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'account';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'bank/account',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'bank/account/{type}',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
    ];
}
