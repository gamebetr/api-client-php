<?php

namespace Gamebetr\ApiClient\Config;

use Gamebetr\ApiClient\Abstracts\BaseConfig;
use Gamebetr\ApiClient\Types\Account;
use Gamebetr\ApiClient\Types\AuthorizationToken;
use Gamebetr\ApiClient\Types\Bank;
use Gamebetr\ApiClient\Types\Currency;
use Gamebetr\ApiClient\Types\Error;
use Gamebetr\ApiClient\Types\Game;
use Gamebetr\ApiClient\Types\Generic;
use Gamebetr\ApiClient\Types\Provider;
use Gamebetr\ApiClient\Types\Transaction;
use Gamebetr\ApiClient\Types\TwoFactor;
use Gamebetr\ApiClient\Types\User;

class Types extends BaseConfig
{
    /**
     * Config.
     * @var array
     */
    protected $config = [
        'account' => Account::class,
        'authorizationToken' => AuthorizationToken::class,
        'bank' => Bank::class,
        'banks' => Bank::class,
        'bank-account' => Account::class,
        'bank-accounts' => Account::class,
        'currency' => Currency::class,
        'currencies' => Currency::class,
        'error' => Error::class,
        'game' => Game::class,
        'generic' => Generic::class,
        'provider' => Provider::class,
        'transaction' => Transaction::class,
        'transactions' => Transaction::class,
        'twoFactor' => TwoFactor::class,
        'user' => User::class,
    ];
}
