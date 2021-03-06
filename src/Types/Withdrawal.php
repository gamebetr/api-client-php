<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Withdrawal extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'withdrawal';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'paybetr/withdrawal',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'paybetr/withdrawal/{id}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'id',
            ],
        ],
        'create' => [
            'endpoint' => 'paybetr/withdrawal',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
                'currency',
                'amount',
                'address',
            ],
        ],
        'confirm' => [
            'endpoint' => 'paybetr/withdrawal/{id}/confirm',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'cancel' => [
            'endpoint' => 'paybetr/withdrawal/{id}/cancel',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'approve' => [
            'endpoint' => 'paybetr/withdrawal/{id}/approve',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'refund' => [
            'endpoint' => 'paybetr/withdrawal/{id}/refund',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
    ];
}
