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
        'find' => [
            'endpoint' => 'gamecenter/game/{id}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'id',
            ],
        ],
        'launch' => [
            'endpoint' => 'gamecenter/game/{id}/launch',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
                'id',
            ],
            'optional_parameters' => [
                'anonymous',
                'currency',
                'private',
            ],
        ],
    ];
}
