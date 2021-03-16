<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class AuthorizationToken extends BaseType
{
    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'refresh' => [
            'endpoint' => 'user/refresh',
            'method' => 'POST',
            'requires_authentication' => false,
            'required_parameters' => [
                'refresh_token',
            ],
        ],
    ];
}
