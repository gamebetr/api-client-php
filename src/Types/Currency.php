<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Currency extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'currency';
    
    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'bank/currency',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'bank/currency/{symbol}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'symbol',
            ],
        ],
        'convert' => [
            'endpoint' => 'paybetr/currency/{symbol}/convert/{to}/{amount?}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'symbol',
                'to',
            ],
            'optional_parameters' => [
                'amount',
            ],
        ],
    ];
}
