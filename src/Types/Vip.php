<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Vip extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'vip';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'info' => [
            'endpoint' => 'vip',
            'method' => 'GET',
            'requires_authentication' => false,
        ],
        'userinfo' => [
            'endpoint' => 'vip/user',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
    ];
}
