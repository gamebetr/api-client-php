<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\IntermediateJsonApiType;

class Transaction extends IntermediateJsonApiType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'transaction';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'bank/transaction',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'bank/transaction/{id}',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'transfer' => [
            'endpoint' => 'bank/transfer',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
                'from',
                'to',
                'amount',
            ],
        ],
    ];
}
