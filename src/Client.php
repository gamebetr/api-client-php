<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Contracts\Config;
use Gamebetr\ApiClient\Contracts\Type;
use Gamebetr\ApiClient\Exceptions\InvalidApiToken;
use Gamebetr\ApiClient\Exceptions\InvalidType;
use Gamebetr\ApiClient\Utility\Type as UtilityType;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class Client
{
    /**
     * Api.
     * @var \Gamebetr\ApiClient\Contracts\Config
     */
    protected Config $api;

    /**
     * Client
     * @var \GuzzleHttp\ClientInterface
     */
    protected ClientInterface $client;

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
     * Raw response.
     * @var string
     */
    protected $response;

    /**
     * Class constructor.
     * @param \Gamebetr\ApiClient\Contracts\Config $api
     * @param \GuzzleHttp\ClientInterface $client
     * @return void
     */
    public function __construct(Config $api, ClientInterface $client = null)
    {
        $this->setApi($api);
        $this->setClient($client);
    }

    /**
     * Static constructor.
     * @param \Gamebetr\ApiClient\Contracts\Config $api
     * @param \GuzzleHttp\ClientInterface $client
     * @return self
     */
    public static function init(Config $api, ClientInterface $client = null) : self
    {
        return new static($api, $client);
    }

    /**
     * Get api.
     * @return \Gamebetr\ApiClient\Contracts\Config
     */
    public function getApi() : Config
    {
        return $this->api;
    }

    /**
     * Set api.
     * @param \Gamebetr\ApiClient\Contracts\Config
     * @return self
     */
    public function setApi(Config $api) : self
    {
        $this->api = $api;

        return $this;
    }

    /**
     * Get client.
     * @return \GuzzleHttp\ClientInterface
     */
    public function getClient() : ClientInterface
    {
        return $this->client;
    }

    /**
     * Set client
     * @param \GuzzleHttp\ClientInterface $client
     * @return self
     */
    public function setClient(ClientInterface $client = null) : self
    {
        $this->client = $client ?? new GuzzleClient();

        return $this;
    }

    /**
     * Get request headers.
     * @return array
     */
    public function getRequestHeaders() : array
    {
        return $this->headers;
    }

    /**
     * Get request header.
     * @param string $header
     * @return string|null
     */
    public function getRequestHeader(string $header) : ?string
    {
        if (!isset($this->headers[$header])) {
            return null;
        }
        return $this->headers[$header];
    }

    /**
     * Set request headers.
     * @param array $headers
     * @return self
     */
    public function setRequestHeaders(array $headers = []) : self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set request header.
     * @param string $header
     * @param string $value
     * @return self
     */
    public function setRequestHeader(string $header, string $value) : self
    {
        $this->headers[$header] = $value;

        return $this;
    }

    /**
     * Get request method
     * @return string|null
     */
    public function getRequestMethod() : ?string
    {
        return $this->method;
    }

    /**
     * Set request method
     * @param string $method
     * @return self
     */
    public function setRequestMethod(string $method = null) : self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Get request parameters.
     * @return array
     */
    public function getRequestParameters() : array
    {
        return $this->parameters;
    }

    /**
     * Get request parameter.
     * @param string $parameter
     * @return mixed
     */
    public function getRequestParameter(string $parameter)
    {
        if (!isset($this->parameters[$parameter])) {
            return null;
        }

        return $this->parameters[$parameter];
    }

    /**
     * Set request parameters.
     * @param array $parameters
     * @return self
     */
    public function setRequestParameters(array $parameters = []) : self
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set request parameter.
     * @param string $parameter
     * @param mixed $value
     * @return self
     */
    public function setRequestParameter(string $parameter, $value) : self
    {
        $this->parameters[$parameter] = $value;

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
     * Reset.
     * @return self
     */
    public function reset() : self
    {
        $this->headers = [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ];
        $this->method = null;
        $this->parameters = [];
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
        if (! $type = array_shift($arguments)) {
            throw new InvalidType();
        }
        if (! $type instanceof Type) {
            $type = UtilityType::make(['type' => $type]);
        }

        return $this->call($name, $type);
    }

    /**
     * Non magic caller.
     * @param string $method
     * @param \Gamebetr\ApiClient\Contracts\Type $type
     * @return self
     */
    public function call(string $method, Type $type) : self
    {
        $requestOptions = call_user_func([$type, $method]);
        //$requestOptions = call_user_func_array([$type, $method]);
        if (isset($requestOptions['endpoint'])) {
            $this->endpoint = $requestOptions['endpoint'];
        }
        if (isset($requestOptions['method'])) {
            $this->method = $requestOptions['method'];
        }
        if (isset($requestOptions['requires_authentication'])) {
            $this->requiresAuth = filter_var($requestOptions['requires_authentication'], FILTER_VALIDATE_BOOL);
        }
        $this->parameters = $type->attributes;

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
        if (! empty($this->filters)) {
            $options['query']['filter'] = $this->filters;
        }
        if (! empty($this->includes)) {
            $options['query']['include'] = implode(',', $this->includes);
        }
        if (! empty($this->sorts)) {
            $options['query']['sort'] = implode(',', $this->sorts);
        }
        if ($this->limit) {
            $options['query']['limit'] = $this->limit;
        }
        if ($this->offset) {
            $options['query']['offset'] = $this->offset;
        }
        if ($this->requiresAuth) {
            if (! $this->api->apiToken) {
                throw new InvalidApiToken();
            }
            $options['headers']['Authorization'] = 'Bearer '.$this->api->apiToken;
        }
        $url = rtrim($this->api->baseUri, '/').'/'.ltrim($this->endpoint, '/');
        try {
            $data = $this->client->request($this->method, $url, $options)->getBody()->getContents();
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
        $this->response = $data;
        $this->reset();

        return UtilityType::make($data);
    }

    /**
     * Get raw response.
     * @return string|null
     */
    public function getRawResponse() : ?string
    {
        return $this->response;
    }
}
