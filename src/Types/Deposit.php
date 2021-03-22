<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Deposit extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'deposit';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'paybetr/deposit',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'paybetr/deposit/{id}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'id',
            ],
        ],
    ];
}
