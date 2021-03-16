<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Contracts\Config;
use Gamebetr\ApiClient\Contracts\Type;
use Gamebetr\ApiClient\Exceptions\InvalidApiToken;
use Gamebetr\ApiClient\Exceptions\InvalidType;
use Gamebetr\ApiClient\Utility\Type as UtilityType;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class Client
{
    /**
     * Api.
     * @var \Gamebetr\ApiClient\Contracts\Config
     */
    protected Config $api;

    /**
     * Headers.
     * @var array
     */
    protected $headers = [
        'Accept' => 'application/vnd.api+json',
        'Content-Type' => 'application/vnd.api+json',
    ];

    /**
     * Method.
     * @var string
     */
    protected $method;

    /**
     * Parameters.
     * @var array
     */
    protected $parameters = [];

    /**
     * Endpoint.
     * @var string
     */
    protected $endpoint;

    /**
     * Filters.
     * @var array
     */
    protected $filters = [];

    /**
     * Includes.
     * @var array
     */
    protected $includes = [];

    /**
     * Sorts.
     * @var array
     */
    protected $sorts = [];

    /**
     * Requires auth.
     * @var bool
     */
    protected $requiresAuth = true;

    /**
     * Limit
     * @var int
     */
    protected $limit;

    /**
     * Offset
     * @var int
     */
    protected $offset;

    /**
     * Class constructor.
     * @param \Gamebetr\ApiClient\Contracts\Config $api
     * @return void
     */
    public function __construct(Config $api)
    {
        $this->api = $api;
    }

    /**
     * Static constructor.
     * @param \Gamebetr\ApiClient\Contracts\Config $api
     * @return self
     */
    public static function init(Config $api) : self
    {
        return new static($api);
    }

    /**
     * Reset.
     * @return self
     */
    public function reset() : self
    {
        $this->headers = [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ];
        $this->parameters = [];
        $this->method = null;
        $this->endpoint = null;
        $this->filters = [];
        $this->includes = [];
        $this->sorts = [];
        $this->requiresAuth = true;
        $this->limit = null;
        $this->offset = null;
        return $this;
    }

    /**
     * Magic method caller.
     * @param string $name
     * @param array $arguments
     * @return self
     */
    public function __call($name, $arguments) : self
    {
        if (!$type = array_shift($arguments)) {
            throw new InvalidType();
        }
        if (!$type instanceof Type) {
            throw new InvalidType();
        }
        $requestOptions = call_user_func_array([$type, $name], $arguments);
        if (isset($requestOptions['endpoint'])) {
            $this->endpoint = $requestOptions['endpoint'];
        }
        if (isset($requestOptions['method'])) {
            $this->method = $requestOptions['method'];
        }
        if (isset($requestOptions['requires_authentication'])) {
            $this->requiresAuth = filter_var($requestOptions['requires_authentication'], FILTER_VALIDATE_BOOL);
        }
        return $this;
    }

    /**
     * Filter.
     * @param string $column
     * @param string $filter
     * @return self
     */
    public function filter(string $column, $filter) : self
    {
        $this->filters[$column] = $filter;
        return $this;
    }

    /**
     * Sort.
     * @param string $sort
     * @return self
     */
    public function sort(string $sort) : self
    {
        $this->sorts[] = $sort;
        return $this;
    }

    /**
     * Include.
     * @param string $include
     * @return self
     */
    public function include(string $include) : self
    {
        $this->includes[] = $include;
        return $this;
    }

    /**
     * Limit.
     * @param int $limit
     * @return self
     */
    public function limit(int $limit) : self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Offset.
     * @param int $offset
     * @return self
     */
    public function offset(int $offset) : self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Make an api request.
     * @return \Gamebetr\ApiClient\Contracts\Type
     */
    public function get() : Type
    {
        $options = [
            'headers' => $this->headers,
            'json' => $this->parameters,
        ];
        if (!empty($this->filters)) {
            $options['query']['filter'] = $this->filters;
        }
        if (!empty($this->includes)) {
            $options['query']['include'] = implode(',', $this->includes);
        }
        if (!empty($this->sorts)) {
            $options['query']['sort'] = implode(',', $this->sorts);
        }
        if ($this->limit) {
            $options['query']['limit'] = $this->limit;
        }
        if ($this->offset) {
            $options['query']['offset'] = $this->offset;
        }
        if ($this->requiresAuth) {
            if (!$this->api->apiToken) {
                throw new InvalidApiToken();
            }
            $options['headers']['Authorization'] = 'Bearer '.$this->api->apiToken;
        }
        $url = rtrim($this->api->baseUri, '/').'/'.ltrim($this->endpoint, '/');
        $client = new GuzzleClient();
        try {
            $data = $client->request($this->method, $url, $options)->getBody()->getContents();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $data = [
                    'type' => 'error',
                    'attributes' => [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode(),
                        'response' => $e->getResponse(),
                    ],
                ];
            } else {
                $data = [
                    'type' => 'error',
                    'attributes' => [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode(),
                    ],
                ];
            }
        }
        $this->reset();
        return UtilityType::make($data);
    }
}
