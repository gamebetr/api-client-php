<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Provider extends BaseType
{
    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'gamecenter/provider',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
    ];
}
