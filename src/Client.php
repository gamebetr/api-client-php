<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Config\Types;
use Gamebetr\ApiClient\Contracts\Config;
use Gamebetr\ApiClient\Contracts\Type;
use Gamebetr\ApiClient\Exceptions\InvalidType;
use GuzzleHttp\Client as GuzzleClient;

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
        $response = $this->request($requestOptions['endpoint'], $requestOptions['method'], $type);
        $data = json_decode($response->getBody()->getContents());
        if (!isset($requestOptions['return_type'])) {
            return get_class($type)::init($data);
        }
        return Types::init()->{$requestOptions['return_type']}::init($data);
    }

    /**
     * Make an api request.
     */
    public function request(string $endpoint, string $method, Type $apiObject)
    {
        $url = rtrim($this->api->baseUri, '/').'/'.ltrim($endpoint, '/');
        $client = new GuzzleClient();
        return $client->request($method, $url, [
            'json' => $apiObject->attributes,
        ]);
    }
}
