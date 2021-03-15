<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Contracts\ApiContract;

class Api implements ApiContract
{
    /**
     * Attributes.
     * @var array
     */
    private $attributes = [
        'baseUri' => 'https://api.gamebetr.com/api/v1',
        'apiToken' => null,
        'allowedMethods' => [
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
        ],
    ];

    /**
     * Filters.
     * @var array
     */
    protected $filters = [];

    /**
     * Sorts.
     * @var array
     */
    protected $sorts = [];

    /**
     * Includes.
     * @var array
     */
    protected $includes = [];

    /**
     * Class constructor.
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            $this->attributes[$attribute] = $value;
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
     * Attribute setter.
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Attribute getter.
     * @param $name
     * @return $mixed
     */
    public function __get($name)
    {
        if (! isset($this->attributes[$name])) {
            return;
        }

        return $this->attributes[$name];
    }

    /**
     * Get all attributes.
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * Get URL.
     * @param string $endpoint
     * @return string
     */
    public function getUrl(string $endpoint) : string
    {
        return rtrim($this->baseUri, '/').'/'.ltrim($endpoint, '/');
    }

    /**
     * Get authorization.
     * @return array
     */
    public function getAuthorization() : array
    {
        $headers = [];
        if ($apiToken = $this->apiToken) {
            $headers['Authorization'] = 'Bearer '.$apiToken;
        }

        return $headers;
    }

    /**
     * Allowed methods.
     * @return array
     */
    public function allowedMethods() : array
    {
        return $this->allowedMethods;
    }

    /**
     * Add filter.
     * @param string $column
     * @param string $filter
     * @return self
     */
    public function addFilter(string $column, string $filter) : self
    {
        $this->filters[$column] = $filter;

        return $this;
    }

    /**
     * Remove filter
     * @param string $column
     * @return self
     */
    public function removeFilter(string $column) : self
    {
        if (isset($this->filters[$column])) {
            unset($this->filters[$column]);
        }

        return $this;
    }

    /**
     * Add include.
     * @param string $include
     * @return self
     */
    public function addInclude(string $include) : self
    {
        if (!in_array($include, $this->includes)) {
            $this->includes[] = $include;
        }

        return $this;
    }

    /**
     * Remove include.
     * @param string $include
     * @return self
     */
    public function removeInclude(string $include) : self
    {
        if ($index = array_search($include, $this->includes)) {
            unset($this->includes[$index]);
        }

        return $this;
    }

    /**
     * Add sort.
     * @param string $sort
     * @return self
     */
    public function addSort(string $sort) : self
    {
        if (!in_array($sort, $this->sorts)) {
            $this->sorts[] = $sort;
        }

        return $this;
    }

    /**
     * Remove sort.
     * @param string $sort
     * @return self
     */
    public function removeSort(string $sort) : self
    {
        if ($index = array_search($sort, $this->sorts)) {
            unset($this->sorts[$index]);
        }

        return $this;
    }

    /**
     * Build query.
     * @return array
     */
    public function buildQuery() : array
    {
        $query = [];
        if (!empty($this->filters)) {
            foreach ($this->filters as $column => $filter) {
                $query['filter'][$column] = $filter;
            }
        }
        if (!empty($this->includes)) {
            $query['include'] = implode(',', $this->includes);
        }
        if (!empty($this->sorts)) {
            $query['sort'] = implode(',', $this->sorts);
        }

        return $query;
    }

    /**
     * Request.
     * @param string $endpoint
     * @param string $method
     * @param array $parameters
     * @param bool $requiresAuth
     * @param array $headers
     * @param array $query
     * @return \Gamebetr\ApiClient\Request
     */
    public function request(
        string $endpoint,
        string $method = 'GET',
        array $parameters = [],
        bool $requiresAuth = true,
        array $headers = [],
        array $query = []
    ) : Request {
        $request = Request::init($this);
        $request->method($method);
        $request->parameters($parameters);
        $request->query($this->buildQuery());
        $request->requiresAuth($requiresAuth);
        foreach ($headers as $header => $value) {
            $request->header($header, $value);
        }
        $request->query($query);
        $request->request($endpoint);

        return $request;
    }
}
