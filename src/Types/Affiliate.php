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
        'info' => [
            'endpoint' => 'affiliate',
            'method' => 'GET',
            'requires_authentication' => false,
        ],
        'userinfo' => [
            'endpoint' => 'affiliate/user',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'userlist' => [
            'endpoint' => 'affiliate/user/list',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
    ];
}
