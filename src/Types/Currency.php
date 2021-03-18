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
            'endpoint' => 'paybetr/currency',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'paybetr/currency/{symbol}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'symbol',
            ],
        ],
    ];
}
