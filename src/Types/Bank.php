<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\IntermediateJsonApiType;

class Bank extends IntermediateJsonApiType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'bank';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'bank',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'bank/{id}',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'create' => [
            'endpoint' => 'bank',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
            ]
        ],
        'update' => [
            'endpoint' => 'bank/{id}',
            'method' => 'PUT',
            'requires_authentication' => true,
            'required_parameters' => [
            ],
        ],
    ];
}
