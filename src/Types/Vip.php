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
        'get' => [
            'endpoint' => 'user/vip',
            'requires_authentication' => true,
        ],
    ];
}
