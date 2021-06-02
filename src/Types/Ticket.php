<?php

namespace Gamebetr\ApiClient\Types;

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
            'endpoint' => 'support/ticket',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'support/ticket/{id}',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'create' => [
            'endpoint' => 'support/ticket',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
                'title',
                'body'
            ],
        ],
    ];
}
