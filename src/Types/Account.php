<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\BaseType;

/**
 *
 * @method list
 * @method find
 * @method reportWinLoss
 * @method reportWinLossByTag
 */
class Account extends BaseType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'account';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'bank/account',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'bank/account/{type}',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'reportWinLoss' => [
            'endpoint' => 'bank/account/{type}/reports/win-loss/{start}/{end}',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'type',
                'start',
                'end',
            ],
        ],
        'reportWinLossByTags' => [
            'endpoint' => 'bank/account/{type}/reports/win-loss-by-tags',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'type',
            ],
        ],
    ];
}
