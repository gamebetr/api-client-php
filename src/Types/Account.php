<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\IntermediateJsonApiType;

/**
 *
 * @method list
 * @method find
 * @method reportWinLoss
 * @method reportWinLossByTag
 */
class Account extends IntermediateJsonApiType
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
        'primary' => [
            'endpoint' => 'bank/account/{type}/primary',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'moonpay' => [
            'endpoint' => 'paybetr/moonpay',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
                'currency',
            ],
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
