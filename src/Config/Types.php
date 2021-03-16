<?php

namespace Gamebetr\ApiClient\Config;

use Gamebetr\ApiClient\Abstracts\BaseConfig;
use Gamebetr\ApiClient\Types\AuthorizationToken;
use Gamebetr\ApiClient\Types\Bank;
use Gamebetr\ApiClient\Types\Error;
use Gamebetr\ApiClient\Types\Game;
use Gamebetr\ApiClient\Types\Generic;
use Gamebetr\ApiClient\Types\Provider;
use Gamebetr\ApiClient\Types\TwoFactor;
use Gamebetr\ApiClient\Types\User;

class Types extends BaseConfig
{
    /**
     * Config.
     * @var array
     */
    protected $config = [
        'authorizationToken' => AuthorizationToken::class,
        'bank' => Bank::class,
        'banks' => Bank::class,
        'error' => Error::class,
        'game' => Game::class,
        'generic' => Generic::class,
        'provider' => Provider::class,
        'twoFactor' => TwoFactor::class,
        'user' => User::class,
    ];
}
