<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Balance extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'balance';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'paybetr/balance',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'symbol',
            ],
        ],
        'find' => [
            'endpoint' => 'paybetr/balance/{symbol}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'symbol',
            ],
        ],
    ];
}
