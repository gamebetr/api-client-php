<?php

namespace Gamebetr\ApiClient\Config;

use Gamebetr\ApiClient\Abstracts\BaseConfig;
use Gamebetr\ApiClient\Types\Account;
use Gamebetr\ApiClient\Types\Address;
use Gamebetr\ApiClient\Types\AuthorizationToken;
use Gamebetr\ApiClient\Types\Balance;
use Gamebetr\ApiClient\Types\Bank;
use Gamebetr\ApiClient\Types\Currency;
use Gamebetr\ApiClient\Types\Deposit;
use Gamebetr\ApiClient\Types\Domain;
use Gamebetr\ApiClient\Types\Error;
use Gamebetr\ApiClient\Types\Game;
use Gamebetr\ApiClient\Types\GameTransaction;
use Gamebetr\ApiClient\Types\Generic;
use Gamebetr\ApiClient\Types\Host;
use Gamebetr\ApiClient\Types\Image;
use Gamebetr\ApiClient\Types\Provider;
use Gamebetr\ApiClient\Types\Tag;
use Gamebetr\ApiClient\Types\Ticket;
use Gamebetr\ApiClient\Types\Transaction;
use Gamebetr\ApiClient\Types\TwoFactor;
use Gamebetr\ApiClient\Types\User;
use Gamebetr\ApiClient\Types\UserVariable;
use Gamebetr\ApiClient\Types\Vocabulary;
use Gamebetr\ApiClient\Types\Withdrawal;

class Types extends BaseConfig
{
    /**
     * Config.
     * @var array
     */
    protected $config = [
        'account' => Account::class,
        'accounts' => Account::class,
        'address' => Address::class,
        'addresses' => Address::class,
        'authorizationToken' => AuthorizationToken::class,
        'authorizationTokens' => AuthorizationToken::class,
        'balance' => Balance::class,
        'balances' => Balance::class,
        'bank' => Bank::class,
        'banks' => Bank::class,
        'bank-account' => Account::class,
        'bank-accounts' => Account::class,
        'currency' => Currency::class,
        'currencies' => Currency::class,
        'deposit' => Deposit::class,
        'deposits' => Deposit::class,
        'domain' => Domain::class,
        'domains' => Domain::class,
        'error' => Error::class,
        'errors' => Error::class,
        'game' => Game::class,
        'games' => Game::class,
        'gameTransaction' => GameTransaction::class,
        'gameTransactions' => GameTransaction::class,
        'generic' => Generic::class,
        'host' => Host::class,
        'hosts' => Host::class,
        'image' => Image::class,
        'images' => Image::class,
        'provider' => Provider::class,
        'providers' => Provider::class,
        'tag' => Tag::class,
        'tags' => Tag::class,
        'ticket' => Ticket::class,
        'transaction' => Transaction::class,
        'transactions' => Transaction::class,
        'twoFactor' => TwoFactor::class,
        'twoFactors' => TwoFactor::class,
        'user' => User::class,
        'users' => User::class,
        'userVariable' => UserVariable::class,
        'userVariables' => UserVariable::class,
        'vocabulary' => Vocabulary::class,
        'vocabularies' => Vocabulary::class,
        'withdrawal' => Withdrawal::class,
        'withdrawals' => Withdrawal::class,
    ];
}
