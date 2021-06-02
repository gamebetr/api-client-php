<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class UserVariable extends BaseType
{
    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'user/variables',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'get' => [
            'endpoint' => 'user/variables/{variable}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'variable',
            ],
        ],
        'create' => [
            'endpoint' => 'user/variables',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
                'variable',
                'value',
            ],
        ],
        'delete' => [
            'endpoint' => 'user/variables/{variable}',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
                'variable',
            ],
        ],
    ];
}
