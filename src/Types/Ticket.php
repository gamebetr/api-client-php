<?php

namespace Gamebetr\ApiClient\Ticket;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Ticket extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'ticket';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'content',
            'method' => 'GET',
            'requires_authentication' => false,
        ],
        'find' => [
            'endpoint' => 'content/{id}',
            'method' => 'GET',
            'requires_authentication' => false,
        ],
        'create' => [
            'endpoint' => 'content',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
            ]
        ],
    ];
}
