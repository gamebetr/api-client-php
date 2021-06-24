<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Config\Types;
use Gamebetr\ApiClient\Contracts\Config;
use Gamebetr\ApiClient\Contracts\Type;
use Gamebetr\ApiClient\Exceptions\InvalidApi;
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
     * Page Size (instead of limit)
     * @var int
     */
    protected $pageSize;

    /**
     * Offset
     * @var int
     */
    protected $offset;

    /**
     * Page Number (instead of offset)
     * @var int
     */
    protected $pageNumber;

    /**
     * Tags
     * @var string
     */
    protected $tags;

    /**
     * Boolean parameters.
     *
     * @var bool[]
     */
    protected $booleans;

    /**
     * Vocabulary
     * @var string
     */
    protected $vocabulary;

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
     * Set endpoint
     * @param string $endpoint
     * @return self
     */
    public function setEndpoint(string $endpoint = null) : self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get url.
     * @return string
     */
    public function getUrl() : string
    {
        if (!$baseUri = $this->api->baseUri) {
            throw new InvalidApi();
        }

        return rtrim(rtrim($baseUri, '/').'/'.ltrim($this->getEndpoint(), '/'), '/');
    }

    /**
     * Get full url.
     * @return string
     */
    public function getFullUrl() : string
    {
        return $this->getUrl().'?'.http_build_query($this->getQuery());
    }

    /**
     * Get filters.
     * @return array
     */
    public function getFilters() : array
    {
        return $this->filters;
    }

    /**
     * Get includes.
     * @return array
     */
    public function getIncludes() : array
    {
        return $this->includes;
    }

    /**
     * Get sorts.
     * @return array
     */
    public function getSorts() : array
    {
        return $this->sorts;
    }

    /**
     * Get requiresAuth.
     * @return bool
     */
    public function getRequiresAuth() : bool
    {
        return $this->requiresAuth;
    }

    /**
     * Get limit.
     * @return int|null
     */
    public function getLimit() : ?int
    {
        return $this->limit;
    }

    /**
     * Get page size.
     * @return int|null
     */
    public function getPageSize() : ?int
    {
        return $this->pageSize;
    }

    /**
     * Get offset.
     * @return int|null
     */
    public function getOffset() : ?int
    {
        return $this->offset;
    }

    /**
     * Get page number.
     * @return int|null
     */
    public function getPageNumber() : ?int
    {
        return $this->pageNumber;
    }

    /**
     * Get tags.
     * @return string|null
     */
    public function getTags() : ?string
    {
        return $this->tags;
    }

    /**
     * Get vocabulary.
     * @return string|null
     */
    public function getVocabulary() : ?string
    {
        return $this->vocabulary;
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
        $this->booleans = [];
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
            $type = Types::init()->$type::init(array_shift($arguments));
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
     * Page size.
     * @param int $size
     * @return self
     */
    public function pageSize(int $size) : self
    {
        $this->pageSize = $size;

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
     * Page number.
     * @param int $number
     * @return self
     */
    public function pageNumber(int $number) : self
    {
        $this->pageNumber = $number;

        return $this;
    }

    /**
     * Tags.
     * @param string $tags
     * @param string $vocabulary
     * @return self
     */
    public function tags(string $tags, $vocabulary = null) : self
    {
        $this->tags = $tags;
        if ($vocabulary) {
            $this->vocabulary = $vocabulary;
        }

        return $this;
    }

    /**
     * Add a boolean query parameter.
     *
     * @param string $key
     *   The parameter name.
     * @param $value
     *   The parameter value. One of 1, true, on, yes. All other values are
     *   treated as false.
     *
     * @return $this
     */
    public function boolean(string $key, $value): self
    {
        $this->booleans[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);

        return $this;
    }

    /**
     * Add multiple booleans to the request.
     *
     * @param array $booleans
     *   A key value array of booleans.
     *
     * @return $this
     */
    public function booleans(array $booleans): self
    {
        foreach ($booleans as $key => $value) {
            $this->boolean($key, $value);
        }
        return $this;
    }

    /**
     * Vocabulary.
     * @param string $vocabulary
     * @return self
     */
    public function vocabulary(string $vocabulary) : self
    {
        $this->vocabulary = $vocabulary;

        return $this;
    }

    /**
     * Get query.
     * @return array
     */
    public function getQuery() : array
    {
        $query = [];
        if (!empty($this->filters)) {
            $query['filter'] = $this->filters;
        }
        if (!empty($this->includes)) {
            $query['include'] = implode(',', $this->includes);
        }
        if (!empty($this->sorts)) {
            $query['sort'] = implode(',', $this->sorts);
        }
        if ($this->limit) {
            $query['page']['size'] = $this->limit;
        }
        // override $this->limit with $this->pageSize
        if ($this->pageSize) {
            $query['page']['size'] = $this->pageSize;
        }
        if ($this->offset) {
            if ($limit = $this->limit ?? $this->pageSize) {
                $query['page']['number'] = $this->offset / $limit;
            }
            $query['page']['number'] = 1;
        }
        // override $this->offset with $this->pageNumber
        if ($this->pageNumber) {
            $query['page']['number'] = $this->pageNumber;
        }
        if ($this->tags) {
            $query['filter']['tags'][0]['name'] = $this->tags;
        }
        if ($this->vocabulary) {
            $query['filter']['tags'][0]['vocabulary'] = $this->vocabulary;
        }
        if ($this->booleans) {
            foreach ($this->booleans as $key => $value) {
                if (!isset($query[$key])) {
                    $query[$key] = $value;
                }
            }
        }

        return $query;
    }

    /**
     * Get request.
     * @return array
     */
    public function getRequest() : array
    {
        $options = [
            'headers' => $this->getRequestHeaders(),
            'json' => $this->getRequestParameters(),
            'query' => $this->getQuery(),
        ];
        if ($this->requiresAuth) {
            if (!$this->api->apiToken) {
                throw new InvalidApiToken();
            }
            $options['headers']['Authorization'] = 'Bearer '.$this->api->apiToken;
        }

        return $options;
    }

    /**
     * Make an api request.
     * @return \Gamebetr\ApiClient\Contracts\Type
     */
    public function get() : Type
    {
        $options = $this->getRequest();
        try {
            $data = $this->client->request($this->getRequestMethod(), $this->getUrl(), $options)->getBody()->getContents();
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
