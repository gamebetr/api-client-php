<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

class Domain extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'domain';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'admin/domains',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
    ];
}
