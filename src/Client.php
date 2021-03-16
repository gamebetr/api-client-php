<?php

namespace Gamebetr\ApiClient;

use Exception;
use Gamebetr\ApiClient\Config\Types;
use Gamebetr\ApiClient\Contracts\Config;
use Gamebetr\ApiClient\Contracts\Type;
use Gamebetr\ApiClient\Exceptions\InvalidApiToken;
use Gamebetr\ApiClient\Exceptions\InvalidType;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;

class Client
{
    /**
     * Api.
     * @var \Gamebetr\ApiClient\Contracts\Config
     */
    protected Config $api;

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
     * Magic method caller.
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (!$type = array_shift($arguments)) {
            throw new InvalidType();
        }
        if (!$type instanceof Type) {
            throw new InvalidType();
        }
        $requestOptions = call_user_func_array([$type, $name], $arguments);
        $requiresAuth = true;
        if (isset($requestOptions['requires_authentication'])) {
            $requiresAuth = filter_var($requestOptions['requires_authentication'], FILTER_VALIDATE_BOOL);
        }
        $response = $this->request($requestOptions['endpoint'], $requestOptions['method'], $type, $requiresAuth);
        $data = json_decode($response->getBody()->getContents());
        if (!isset($requestOptions['return_type'])) {
            return get_class($type)::init($data);
        }
        return Types::init()->{$requestOptions['return_type']}::init($data);
    }

    /**
     * Make an api request.
     */
    public function request(string $endpoint, string $method, Type $apiObject, $requiresAuth = true)
    {
        if ($requiresAuth && !$this->api->apiToken) {
            throw new InvalidApiToken();
        }
        $options = [
            'headers' => [
                'Accept' => 'application/vnd.api+json',
                'Content-Type' => 'application/vnd.api+json',
            ],
            'json' => $apiObject->attributes,
            'http_errors' => false,
        ];
        if ($requiresAuth) {
            $options['headers']['Authorization'] = 'Bearer '.$this->api->apiToken;
        }
        $url = rtrim($this->api->baseUri, '/').'/'.ltrim($endpoint, '/');
        $client = new GuzzleClient();
        return $client->request($method, $url, $options);
    }
}
