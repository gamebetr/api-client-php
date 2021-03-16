<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class User extends BaseType
{
    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'login' => [
            'endpoint' => 'user/login',
            'method' => 'POST',
            'return_type' => 'authorizationToken',
            'requires_authentication' => false,
            'required_parameters' => [
                'email',
                'password',
            ],
        ],
        'register' => [
            'endpoint' => 'user/register',
            'method' => 'POST',
            'requires_authentication' => false,
            'required_parameters' => [
                'name',
                'email',
                'password',
            ],
        ],
        'me' => [
            'endpoint' => 'user',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
    ];
}
