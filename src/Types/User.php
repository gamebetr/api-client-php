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
        ],
        'register' => [
            'endpoint' => 'user/register',
            'method' => 'POST',
        ],
    ];
}
