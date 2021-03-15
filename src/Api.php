<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Exceptions\InvalidApiToken;
use Gamebetr\ApiClient\Exceptions\UnknownType;
use GuzzleHttp\Client;

class Api
{
    /**
     * Attributes.
     * @var array
     */
    protected $attributes = [
        'baseUri' => 'https://api.gamebetr.com/api/v1',
        'apiToken' => null,
    ];

    /**
     * Request headers.
     * @var array
     */
    protected $requestHeaders = [
        'Accept' => 'application/vnd.api+json',
        'Content-Type' => 'application/vnd.api+json',
    ];

    /**
     * Request uri.
     * @var string
     */
    protected $requestUri;

    /**
     * Request method.
     * @var string
     */
    protected $requestMethod;

    /**
     * Request query parameters.
     * @var array
     */
    protected $requestQuery = [];

    /**
     * Request parameters.
     * @var array
     */
    protected $requestParameters = [];

    /**
     * Response headers.
     * @var array
     */
    protected $responseHeaders = [];

    /**
     * Response status.
     * @var int
     */
    protected $responseStatus = 0;

    /**
     * Response reason.
     * @var string
     */
    protected $responseReason = null;

    /**
     * Response body.
     * @var string
     */
    protected $responseBody = null;

    /**
     * Objects.
     * @var array
     */
    protected $objects = [];

    /**
     * Class constructor.
     * @var array $attributes
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
     * @var array $attributes
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
     * Get response headers.
     * @return array
     */
    public function getResponseHeaders() : array
    {
        return $this->responseHeaders;
    }

    /**
     * Get response status.
     * @return int
     */
    public function getResponseStatus() : int
    {
        return $this->responseStatus;
    }

    /**
     * Get response reason.
     * @return string|null
     */
    public function getResponseReason() : ?string
    {
        return $this->responseReason;
    }

    /**
     * Get response body.
     * @return string|null
     */
    public function getResponseBody() : ?string
    {
        return $this->responseBody;
    }

    /**
     * Get objects.
     * @return array
     */
    public function getObjects() : array
    {
        return $this->objects;
    }

    /**
     * Get first object.
     * @return \Gamebetr\ApiClient\ApiObject|null
     */
    public function first() : ?ApiObject
    {
        return reset($this->objects);
    }

    /**
     * Get last object.
     * @return \Gamebetr\ApiClient\ApiObject|null
     */
    public function last() : ?ApiObject
    {
        return end($this->objects);
    }

    /***************************************************************************
     * CRUD METHODS
     **************************************************************************/

    /**
     * Create
     * @param \Gamebetr\ApiClient\ApiObject $apiObject
     * @return self
     */
    public function create(ApiObject $apiObject) : self
    {
        switch ($apiObject->type) {
            case 'user':
                $this->requestMethod = 'POST';
                $this->requestUri = 'user/create';
                $this->requestParameters = $apiObject->attributes;
                break;
            default:
                throw new UnknownType();
                break;
        }
        return $this->request();
    }

    /**
     * Retrieve
     * @param \Gamebetr\ApiClient\ApiObject $apiObject
     * @return self
     */
    public function retrieve(ApiObject $apiObject) : self
    {
        switch ($apiObject->type) {
            case 'user':
                $this->requestMethod = 'GET';
                $this->requestUri = 'user/'.$apiObject->id;
                break;
            default:
                throw new UnknownType();
                break;
        }
        return $this->request();
    }

    /**
     * Update
     * @param \Gamebetr\ApiClient\ApiObject $apiObject
     * @return self
     */
    public function update(ApiObject $apiObject) : self
    {
        switch ($apiObject->type) {
            case 'user':
                $this->requestMethod = 'PUT';
                $this->requestUri = 'user/'.$apiObject->id;
                $this->requestParameters = $apiObject->attributes;
                break;
            default:
                throw new UnknownType();
                break;
        }
        return $this->request();
    }

    /**
     * Delete
     * @param \Gamebetr\ApiClient\ApiObject $apiObject
     * @return self
     */
    public function delete(ApiObject $apiObject) : self
    {
        switch ($apiObject->type) {
            case 'user':
                $this->requestMethod = 'DELETE';
                $this->requestUri = 'user/'.$apiObject->id;
                break;
            default:
                throw new UnknownType();
                break;
        }
        return $this->request();
    }

    /***************************************************************************
     * USER SPECIAL METHODS
     **************************************************************************/

    /**
     * Login
     * @param string $email
     * @param string $password
     * @return self
     */
    public function login(string $email, string $password) : self
    {
        $this->requestMethod = 'POST';
        $this->requestUri = 'user/login';
        $this->requestParameters = [
            'email' => $email,
            'password' => $password,
        ];
        return $this->request(false);
    }

    /**
     * Request.
     * @return self
     */
    protected function request($protected = true) : self
    {
        if ($protected) {
            if (!$this->apiToken) {
                throw new InvalidApiToken();
            }
            $this->requestHeaders['Authorization'] = 'Bearer '.$this->apiToken;
        }
        $url = rtrim($this->baseUri, '/').'/'.ltrim($this->requestUri, '/');
        $client = new Client();
        $response = $client->request($this->requestMethod, $url, [
            'headers' => $this->requestHeaders,
            'query' => $this->requestQuery,
            'json' => $this->requestParameters,
        ]);
        $this->responseHeaders = $response->getHeaders();
        $this->responseStatus = $response->getStatusCode();
        $this->responseReason = $response->getReasonPhrase();
        $this->responseBody = $response->getBody()->getContents();
        $data = json_decode($this->responseBody);
        if (isset($data->data)) {
            if (is_array($data->data)) {
                foreach ($data->data as $apiObject) {
                    $this->objects[] = ApiObject::init($apiObject);
                }
            } else {
                $this->objects[] = ApiObject::init($data->data);
            }
        }

        return $this;
    }
}
