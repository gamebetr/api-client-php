<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Affiliate extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'affiliate';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'get' => [
            'endpoint' => 'user/affiliate',
            'requires_authentication' => true,
        ],
    ];
}
