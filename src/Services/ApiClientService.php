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
        $apiToken = $this->request('POST', '/api/v1/user/login', ['email' => $email, 'password' => $password]);

        return json_decode($apiToken);
    }

    /**
     * Me.
     * @param string $apiToken
     * @return \stdClass
     */
    public function me() : stdClass
    {
        $me = $this->request('GET', '/api/v1/user', [], true);

        return json_decode($me);
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
        $user = $this->request('POST', '/api/v1/user/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], true);

        return json_decode($user);
    }

    /**
     * Update.
     * @param array $attributes
     * @return \stdClass
     */
    public function update(array $attributes = []) : stdClass
    {
        $user = $this->request('POST', '/api/v1/user/update', $attributes, true);

        return json_decode($user);
    }

    /**
     * Enable 2fa.
     * @return \stdClass
     */
    public function enable2fa() : stdClass
    {
        $twoFactor = $this->request('GET', '/api/v1/user/enable2fa', [], true);

        return json_decode($twoFactor);
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
        $accounts = $this->request('GET', '/api/v1/bank/account', [], true);

        return json_decode($accounts);
    }

    /**
     * Get account.
     * @param string $uuid
     * @return \stdClass
     */
    public function getAccount(string $uuid) : stdClass
    {
        $account = $this->request('GET', '/api/v1/bank/account/'.$uuid, [], true);

        return json_decode($account);
    }

    /**
     * List transactions.
     * @return \stdClass
     */
    public function listTransactions() : stdClass
    {
        $transactions = $this->request('GET', '/api/v1/bank/transaction', [], true);

        return json_decode($transactions);
    }

    /**
     * Get transaction.
     * @param string $uuid
     * @return \stdClass
     */
    public function getTransaction(string $uuid) : stdClass
    {
        $transaction = $this->request('GET', '/api/v1/bank/transaction/'.$uuid, [], true);

        return json_decode($transaction);
    }

    /**
     * END USER PAYBETR ENDPOINTS.
     */

    /**
     * Make an api request.
     * @param string $method
     * @param string $uri
     * @param array $data
     * @return /stdClass
     */
    public function request(string $method, string $uri, array $data = [], bool $needsAuth = false)
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

        return $response;
    }
}
