<?php

namespace Gamebetr\ApiClient;

use Exception;
use Gamebetr\ApiClient\Contracts\ApiContract;
use Gamebetr\ApiClient\Contracts\RequestContract;
use Gamebetr\ApiClient\Exceptions\MethodNotAllowed;
use GuzzleHttp\Client;

class Request implements RequestContract
{
    /**
     * Api class.
     * @var \Gamebetr\ApiClient\Contracts\ApiContract
     */
    public $api;

    /**
     * Method.
     * @var string
     */
    public $method = 'GET';

    /**
     * Requires auth.
     * @var bool
     */
    public $requiresAuth = true;

    /**
     * Headers.
     * @var array
     */
    public $headers = [
        'Accept' => 'application/vnd.api+json',
        'Content-Type' => 'application/vnd.api+json',
    ];

    /**
     * Parameters.
     * @var array
     */
    public $parameters = [];

    /**
     * Status.
     * @var int
     */
    protected $status = 0;

    /**
     * Reason.
     * @var string
     */
    protected $reason = null;

    /**
     * Response.
     * @var string
     */
    protected $response = null;

    /**
     * Class constructor.
     * @param \Gamebetr\ApiClient\Contracts\ApiContract $api
     * @return void
     */
    public function __construct(ApiContract $api)
    {
        $this->api = $api;
    }

    /**
     * Static constructor.
     * @param \Gamebetr\ApiClient\Contracts\ApiContract $api
     * @return self
     */
    public static function init(ApiContract $api) : self
    {
        return new static($api);
    }

    /**
     * Magic getter.
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Set method.
     * @param string $method
     * @return self
     */
    public function method(string $method) : self
    {
        if (! in_array($method, $this->api->allowedMethods())) {
            throw new MethodNotAllowed('Method not allowed', 403);
        }
        $this->method = $method;

        return $this;
    }

    /**
     * Set requiresAuth.
     * @param bool $value
     * @return self
     */
    public function requiresAuth(bool $value) : self
    {
        $this->requiresAuth = $value;

        return $this;
    }

    /**
     * Set headers.
     * @param array $headers
     * @return self
     */
    public function headers(array $headers) : self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set header.
     * @param string $header
     * @param string $value
     * @return self
     */
    public function header(string $header, string $value) : self
    {
        $this->headers[$header] = $value;

        return $this;
    }

    /**
     * Set parameters.
     * @param array $parameters
     * @return self
     */
    public function parameters(array $parameters) : self
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set parameter.
     * @param string $parameter
     * @param mixed $value
     * @return self
     */
    public function parameter(string $parameter, $value) : self
    {
        $this->parameters[$parameter] = $value;

        return $this;
    }

    /**
     * Make request.
     * @param string $endpoint
     * @return self
     */
    public function request(string $endpoint) : self
    {
        $headers = $this->headers;
        if ($this->requiresAuth) {
            $headers = array_merge($headers, $this->api->getAuthorization());
        }
        $client = new Client();
        try {
            $response = $client->request($this->method, $this->api->getUrl($endpoint), [
                'headers' => $headers,
                'json' => $this->parameters,
            ]);
            $this->status = $response->getStatusCode();
            $this->reason = $response->getReasonPhrase();
            $this->response = $response->getBody()->getContents();
        } catch (Exception $e) {
            $this->status = $e->getCode();
            $this->reason = $e->getMessage();
        }

        return $this;
    }

    /**
     * Get status.
     * @return int
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * Get reason.
     * @return string|null
     */
    public function getReason() : ?string
    {
        return $this->reason;
    }

    /**
     * Get response.
     * @return string|null
     */
    public function getResponse() : ?string
    {
        return $this->response;
    }
}
