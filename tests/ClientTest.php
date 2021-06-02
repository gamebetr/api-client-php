<?php

namespace Gamebetr\ApiClient\Tests;

use Gamebetr\ApiClient\Client;
use Gamebetr\ApiClient\Config\Api;
use GuzzleHttp\Client as GuzzleClient;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * Api config.
     * @var \Gamebetr\ApiClient\Contracts\Config
     */
    protected $api;

    /**
     * Class constructor
     * @return void
     */
    public function __construct()
    {
        $this->api = Api::init([]);
    }
    /**
     * Test can instanciate client
     */
    public function testCanInstanciateClient()
    {
        $client = new Client($this->api);
        $this->assertInstanceOf('Gamebetr\ApiClient\Client', $client);
    }

    /**
     * Test can init client
     */
    public function testCanInitClient()
    {
        $client = Client::init($this->api);
        $this->assertInstanceOf('Gamebetr\ApiClient\Client', $client);
    }

    /**
     * Test can get api
     */
    public function testCanSetAndGetApi()
    {
        $client = Client::init($this->api);
        $client->setApi($this->api);
        $api = $client->getApi();
        $this->assertInstanceOf('Gamebetr\ApiClient\Contracts\Config', $api);
        $config = $api->getConfig();
        $this->assertIsArray($config);
        $this->assertArrayHasKey('baseUri', $config);
        $this->assertArrayHasKey('apiToken', $config);
        $this->assertSame($this->api['baseUri'], $config['baseUri']);
        $this->assertSame($this->api['apiToken'], $config['apiToken']);
    }

    /**
     * Test can get client
     */
    public function testCanSetAndGetClient()
    {
        $client = Client::init($this->api);
        $client->setClient(new GuzzleClient());
        $this->assertInstanceOf('GuzzleHttp\Client', $client->getClient());
    }

    /**
     * Test can set and get request headers
     */
    public function testCanSetAndGetRequestHeaders()
    {
        $client = Client::init($this->api);
        $client->setRequestHeaders([
            'param' => 'value',
        ]);
        $headers = $client->getRequestHeaders();
        $this->assertIsArray($headers);
        $this->assertArrayHasKey('param', $headers);
        $value = $client->getRequestHeader('param');
        $this->assertSame('value', $value);
        $this->assertNull($client->getRequestHeader('does_not_exist'));
    }

    /**
     * Test can set and get request method
     */
    public function testCanSetAndGetRequestMethod()
    {
        $client = Client::init($this->api);
        $this->assertNull($client->getRequestMethod());
        $client->setRequestMethod('GET');
        $this->assertSame('GET', $client->getRequestMethod());
    }

    /**
     * Test can set and get request parameters
     */
    public function testCanSetAndGetRequestParameters()
    {
        $client = Client::init($this->api);
        $this->assertEmpty($client->getRequestParameters());
        $client->setRequestParameters([
            'name' => 'Joe',
            'email' => 'joe@example.com',
        ]);
        $this->assertArrayHasKey('name', $client->getRequestParameters());
        $this->assertArrayHasKey('email', $client->getRequestParameters());
        $client->setRequestParameter('password', 'mypassword');
        $this->assertArrayHasKey('password', $client->getRequestParameters());
        $this->assertSame('Joe', $client->getRequestParameter('name'));
    }

    /**
     * Test can set and get endpoint
     */
    public function testCanSetAndGetEndpoint()
    {
        $client = Client::init($this->api);
        $this->assertNull($client->getEndpoint());
        $client->setEndpoint('user');
        $this->assertSame('user', $client->getEndpoint());
    }

    /**
     * Test can get url
     */
    public function testCanGetUrl()
    {
        $client = Client::init($this->api);
        $this->assertIsString($client->getUrl());
    }
}
