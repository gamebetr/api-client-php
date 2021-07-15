<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\IntermediateJsonApiType;

class Hold extends IntermediateJsonApiType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'hold';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'bank/hold',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'bank/hold/{id}',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
    ];
}
