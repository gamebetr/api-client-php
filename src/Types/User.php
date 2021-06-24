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
        'enable2fa' => [
            'endpoint' => 'user/enable2fa',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'disable2fa' => [
            'endpoint' => 'user/disable2fa',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'update' => [
            'endpoint' => 'user/update',
            'method' => 'POST',
            'requires_authentication' => true,
            'optional_parameters' => [
                'name',
                'email',
                'password',
            ],
        ],
        'list' => [
            'endpoint' => 'user/list',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'user/{id}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'id',
            ],
        ],
        'adminupdate' => [
            'endpoint' => 'user/{id}',
            'method' => 'POST',
            'requires_authentication' => true,
        ],
        'create' => [
            'endpoint' => 'user/create',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
                'name',
                'email',
                'password',
            ],
        ],
        'vip' => [
            'endpoint' => 'user/vip',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'affiliate' => [
            'endpoint' => 'user/affiliate',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
    ];
}
