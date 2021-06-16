<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\IntermediateJsonApiType;

/**
 *
 * @method list
 * @method find
 * @method create
 * @method update
 * @method reportWinLoss
 * @method reportWinLossTopUsersByTag
 * @method reportWinLossByTag
 */
class Bank extends IntermediateJsonApiType
{
    /**
     * Type.
     * @var string
     */
    public $type = 'bank';

    /**
     * Methods.
     * @var array
     */
    protected $methods = [
        'list' => [
            'endpoint' => 'bank',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'find' => [
            'endpoint' => 'bank/{id}',
            'method' => 'GET',
            'requires_authentication' => true,
        ],
        'create' => [
            'endpoint' => 'bank',
            'method' => 'POST',
            'requires_authentication' => true,
            'required_parameters' => [
            ]
        ],
        'update' => [
            'endpoint' => 'bank/{id}',
            'method' => 'PUT',
            'requires_authentication' => true,
            'required_parameters' => [
            ],
        ],
        'reportWinLoss' => [
            'endpoint' => 'bank/{id}/reports/win-loss',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'id',
            ],
        ],
        'reportWinLossTopUsersByTag' => [
            'endpoint' => 'bank/{id}/reports/win-loss-top-by-tag',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'id',
            ],
        ],
        'reportWinLossByTags' => [
            'endpoint' => 'bank/{id}/reports/win-loss-by-tags',
            'method' => 'GET',
            'requires_authentication' => true,
            'required_parameters' => [
                'id',
            ],
        ],
    ];
}
