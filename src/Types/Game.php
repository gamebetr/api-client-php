<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Game extends BaseType
{
    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'gamecenter/game',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
    ];
}
