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
     * Domain id.
     * @var int
     */
    protected $domainId;

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
        if (isset($attributes['domainId'])) {
            $this->setDomainId($attributes['domainId']);
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
     * Set domain id.
     * @param int $domainId
     * @return self
     */
    public function setDomainId(int $domainId = null) : self
    {
        $this->domainId = $domainId;

        return $this;
    }

    /**
     * Get domain id.
     * @return int|null
     */
    public function getDomainId() : ?int
    {
        return $this->domainId;
    }

    /**
     * *************
     * API ENDPOINTS.
     * *************
     */

    /**
     * Login.
     * @param string $email
     * @param string $password
     * @param int $domainId
     * @return \stdClass
     */
    public function login(string $email, string $password, int $domainId = null)
    {
        if ($domainId) {
            $this->setDomainId($domainId);
        }
        $apiToken = $this->request('POST', '/api/v1/login', ['domain_id' => $this->getDomainId(), 'email' => $email, 'password' => $password]);

        return json_decode($apiToken);
    }

    /**
     * Me.
     * @param string $apiToken
     * @return \stdClass
     */
    public function me() : stdClass
    {
        $me = $this->request('GET', '/api/v1/me', [], true);

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
        $user = $this->request('POST', '/api/v1/register', [
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
        $user = $this->request('POST', '/api/v1/update', $attributes, true);

        return json_decode($user);
    }

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
                'DomainId: '.$this->getDomainId(),
            ]);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
