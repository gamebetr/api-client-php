<?php

namespace Gamebetr\ApiClientPhp\Services;

use stdClass;

class ApiClientService
{
    /**
     * Api token.
     * @var string
     */
    protected $apiToken;

    /**
     * Base uri.
     * @var string
     */
    protected $baseUri = 'https://api.gamebetr.com';

    /**
     * Class constructor.
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        if (isset($attributes['apiToken'])) {
            $this->setApiToken($attributes['apiToken']);
        }
        if (isset($attributes['baseUri'])) {
            $this->setBaseUri($attributes['baseUri']);
        }
    }

    /**
     * Static constructor.
     * @param array $attributes
     * @return self
     */
    public static function init(array $attributes = []) : self
    {
        return new static($attributes);
    }

    /**
     * Set api token.
     * @param string $apiToken
     * @return self
     */
    public function setApiToken(string $apiToken = null) : self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * Get api token.
     * @return string|null
     */
    public function getApiToken() : ?string
    {
        return $this->apiToken;
    }

    /**
     * Set base uri.
     * @param string $baseUri
     * @return self
     */
    public function setBaseUri(string $baseUri = null) : self
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * Get base uri.
     * @return string|null
     */
    public function getBaseUri() : ?string
    {
        return $this->baseUri;
    }

    /**
     * END USER ACCOUNT ENDPOINTS.
     */

    /**
     * Login.
     * @param string $email
     * @param string $password
     * @return \stdClass
     */
    public function login(string $email, string $password)
    {
        return $this->request('POST', '/api/v1/user/login', ['email' => $email, 'password' => $password], false);
    }

    /**
     * Me.
     * @param string $apiToken
     * @return \stdClass
     */
    public function me() : stdClass
    {
        return $this->request('GET', '/api/v1/user', [], true);
    }

    /**
     * Register.
     * @param string $name
     * @param string $email
     * @param string $password
     * @return \stdClass
     */
    public function register(string $name, string $email, string $password) : stdClass
    {
        return $this->request('POST', '/api/v1/user/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], false);
    }

    /**
     * Update.
     * @param array $attributes
     * @return \stdClass
     */
    public function update(array $attributes = []) : stdClass
    {
        return $this->request('POST', '/api/v1/user/update', $attributes, true);
    }

    /**
     * Enable 2fa.
     * @return \stdClass
     */
    public function enable2fa() : stdClass
    {
        return $this->request('GET', '/api/v1/user/enable2fa', [], true);
    }

    /**
     * Disable 2fa.
     * @return void
     */
    public function disable2fa()
    {
        $this->request('GET', '/api/v1/user/disable2fa', [], true);
    }

    /**
     * END USER BANK ENDPOINTS.
     */

    /**
     * List accounts.
     * @return \stdClass
     */
    public function listAccounts() : stdClass
    {
        return $this->request('GET', '/api/v1/bank/account', [], true);
    }

    /**
     * Get account.
     * @param string $uuid
     * @return \stdClass
     */
    public function getAccount(string $uuid) : stdClass
    {
        return $this->request('GET', '/api/v1/bank/account/'.$uuid, [], true);
    }

    /**
     * List transactions.
     * @return \stdClass
     */
    public function listTransactions() : stdClass
    {
        return $this->request('GET', '/api/v1/bank/transaction', [], true);
    }

    /**
     * Get transaction.
     * @param string $uuid
     * @return \stdClass
     */
    public function getTransaction(string $uuid) : stdClass
    {
        return $this->request('GET', '/api/v1/bank/transaction/'.$uuid, [], true);
    }

    /**
     * END USER PAYBETR ENDPOINTS.
     */

    /**
     * List currencies.
     * @return \stdClass
     */
    public function listCurrencies() : stdClass
    {
        return $this->request('GET', '/api/v1/paybetr/currency', [], true);
    }

    /**
     * Get currency.
     * @param string $symbol
     * @return \stdClass
     */
    public function getCurrency(string $symbol) : stdClass
    {
        return $this->request('GET', '/api/v1/paybetr/currency/'.$symbol, [], true);
    }

    /**
     * Convert currency.
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return stdClass
     */
    public function convertCurrency(string $from, string $to, float $amount = 1) : stdClass
    {
        return $this->request('GET', '/api/v1/paybetr/currency/'.$from.'/convert/'.$to.'/'.$amount, [], true);
    }

    /**
     * List addresses.
     * @return \stdClass
     */
    public function listAddresses() : stdClass
    {
        return $this->request('GET', '/api/v1/paybetr/address', [], true);
    }

    /**
     * Get address.
     * @param string $address
     * @return \stdClass
     */
    public function getAddress(string $address) : stdClass
    {
        return $this->request('GET', '/api/v1/paybetr/address/'.$address, [], true);
    }

    /**
     * Create address.
     * @param string $symbol
     * @return \stdClass
     */
    public function createAddress(string $symbol) : stdClass
    {
        return $this->request('POST', '/api/v1/paybetr/address', ['symbol' => $symbol], true);
    }

    /**
     * List withdrawals.
     * @return \stdClass
     */
    public function listWithdrawals() : stdClass
    {
        return $this->request('GET', '/api/v1/paybetr/withdrawal', [], true);
    }

    /**
     * Get withdrawal.
     * @param string $uuid
     * @return \stdClass
     */
    public function getWithdrawal(string $uuid) : stdClass
    {
        return $this->request('GET', '/api/v1/paybetr/withdrawal/'.$uuid, [], true);
    }

    /**
     * Create withdrawal.
     * @param string $symbol
     * @param float $amount
     * @param $externalId
     * @return \stdClass
     */
    public function createWithdrawal(string $symbol, float $amount, $externalId = null) : stdClass
    {
        return $this->request('POST', '/api/v1/paybetr/withdrawal', ['symbol' => $symbol, 'amount' => $amount, 'external_id' => $externalId], true);
    }

    /**
     * ADMIN USER ROUTES.
     */

    /**
     * List users.
     * @return \stdClass
     */
    public function listUsers() : stdClass
    {
        return $this->request('GET', '/api/v1/admin/user');
    }

    /**
     * Create user.
     * @param string $name
     * @param string $email
     * @param string $password
     * @return \stdClass
     */
    public function createUser(string $name, string $email, string $password) : stdClass
    {
        return $this->request('POST', '/api/v1/admin/user', ['name' => $name, 'email' => $email, 'password' => $password]);
    }

    /**
     * Get user.
     * @param string $uuid
     * @return \stdClass
     */
    public function getUser(string $uuid) : stdClass
    {
        return $this->request('GET', '/api/v1/admin/user/'.$uuid);
    }

    /**
     * Update user.
     * @param string $uuid
     * @param array $params
     * @return \stdClass
     */
    public function updateUser(string $uuid, array $params = []) : stdClass
    {
        return $this->request('PUT', '/api/v1/admin/user/'.$uuid, $params);
    }

    /**
     * Enable 2fa.
     * @param string $uuid
     * @return \stdClass
     */
    public function adminEnable2fa(string $uuid) : stdClass
    {
        return $this->request('GET', '/api/v1/admin/user/'.$uuid.'/enable2fa');
    }

    /**
     * Disable 2fa.
     * @param string $uuid
     * @return void
     */
    public function adminDisable2fa(string $uuid)
    {
        $this->request('GET', '/api/v1/admin/user/'.$uuid.'/disable2fa');
    }

    /**
     * Create api token.
     * @param string $uuid
     * @return \stdClass
     */
    public function createApiToken(string $uuid) : stdClass
    {
        return $this->request('GET', '/api/v1/admin/user/'.$uuid.'/apitoken');
    }

    /**
     * Make an api request.
     * @param string $method
     * @param string $uri
     * @param array $data
     * @return /stdClass
     */
    public function request(string $method, string $uri, array $data = [], bool $needsAuth = true) : stdClass
    {
        $ch = curl_init($this->getBaseUri().$uri);
        if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }
        if ($needsAuth) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '.$this->getApiToken(),
            ]);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}
