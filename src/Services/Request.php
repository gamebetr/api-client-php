<?php

namespace Gamebetr\ApiClient\Services;

use stdClass;

class Request
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
     * Endpoint.
     * @var string
     */
    protected $endpoint;

    /**
     * Method.
     * @var string
     */
    protected $method = 'GET';

    /**
     * Parameters.
     * @var array
     */
    protected $parameters = [];

    /**
     * Status code.
     * @var int
     */
    protected $status = 0;

    /**
     * Response.
     * @var \stdClass
     */
    protected $response;

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
        if (isset($attributes['endpoint'])) {
            $this->setEndpoint($attributes['endpoint']);
        }
        if (isset($attributes['method'])) {
            $this->setMethod($attributes['method']);
        }
        if (isset($attributes['parameters'])) {
            $this->setParameters($attributes['parameters']);
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
    public function setBaseUri(string $baseUri) : self
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * Get base uri.
     * @return string
     */
    public function getBaseUri() : string
    {
        return $this->baseUri;
    }

    /**
     * Set endpoint.
     * @param string $endpoint
     * @return self
     */
    public function setEndpoint(string $endpoint) : self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get endpoint.
     * @return string|null
     */
    public function getEndpoint() : ?string
    {
        return $this->endpoint;
    }

    /**
     * Set method.
     * @param string $method
     * @return self
     */
    public function setMethod(string $method = null) : self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method.
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * Set parameters.
     * @param array $parameters
     * @return self
     */
    public function setParameters(array $parameters = []) : self
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set parameter.
     * @param string $parameter
     * @param $value
     * @return self
     */
    public function setParameter(string $parameter, $value) : self
    {
        $this->parameters[$parameter] = $value;

        return $this;
    }

    /**
     * Get parameters.
     * @return array
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }

    /**
     * Get parameter.
     * @param string $parameter
     * @return mixed
     */
    public function getParameter(string $parameter)
    {
        if (! isset($this->parameters[$parameter])) {
            return;
        }

        return $this->parameters[$parameter];
    }

    /**
     * Get url.
     * @return string
     */
    public function getUrl() : string
    {
        return rtrim($this->getBaseUri(), '/').'/'.ltrim($this->getEndpoint(), '/');
    }

    /**
     * Make an api request.
     * @return /stdClass
     */
    public function request() : stdClass
    {
        $ch = curl_init($this->getUrl());
        $method = $this->getMethod();
        if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->getParameters()));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }
        if ($apiToken = $this->getApiToken()) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '.$apiToken,
            ]);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}
