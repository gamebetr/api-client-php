<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Address extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'address';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'paybetr/address/{symbol}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'symbol',
            ],
        ],
        'find' => [
            'endpoint' => 'paybetr/address/{address}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'address',
            ],
        ],
        'create' => [
            'endpoint' => 'paybetr/address',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
                'symbol',
            ],
            'optional_parameters' => [
                'external_id',
            ],
        ],
    ];
}
