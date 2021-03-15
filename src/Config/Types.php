<?php

namespace Gamebetr\ApiClient\Config;

use Gamebetr\ApiClient\Abstracts\BaseConfig;
use Gamebetr\ApiClient\Types\AuthorizationToken;
use Gamebetr\ApiClient\Types\Generic;
use Gamebetr\ApiClient\Types\User;

class Types extends BaseConfig
{
    /**
     * Config.
     * @var array
     */
    protected $config = [
        'authorizationToken' => AuthorizationToken::class,
        'generic' => Generic::class,
        'user' => User::class,
    ];
}
