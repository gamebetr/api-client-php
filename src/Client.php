<?php

namespace Gamebetr\ApiClient;

use Exception;
use Gamebetr\ApiClient\Config\Types;
use Gamebetr\ApiClient\Contracts\Config;
use Gamebetr\ApiClient\Contracts\Type;
use Gamebetr\ApiClient\Exceptions\InvalidApiToken;
use Gamebetr\ApiClient\Exceptions\InvalidType;
use Gamebetr\ApiClient\Utility\Type as UtilityType;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;

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
        return $this->request($requestOptions['endpoint'], $requestOptions['method'], $type, $requiresAuth);
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
        ];
        if ($requiresAuth) {
            $options['headers']['Authorization'] = 'Bearer '.$this->api->apiToken;
        }
        $url = rtrim($this->api->baseUri, '/').'/'.ltrim($endpoint, '/');
        $client = new GuzzleClient();
        try {
            $response = $client->request($method, $url, $options);
            return UtilityType::make($response->getBody()->getContents());
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return UtilityType::make([
                    'type' => 'error',
                    'attributes' => [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode(),
                        'response' => $e->getResponse(),
                    ],
                ]);
            } else {
                return UtilityType::make([
                    'type' => 'error',
                    'attributes' => [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode(),
                    ],
                ]);
            }
        }
    }
}
