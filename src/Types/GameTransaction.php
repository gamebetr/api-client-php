<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class GameTransaction extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'gameTransaction';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'gamecenter/transaction',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'gamecenter/transaction/{id}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'id',
            ],
        ],
    ];
}
