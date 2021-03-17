<?php

namespace Gamebetr\ApiClient\Tests;

use Gamebetr\ApiClient\Client;
use Gamebetr\ApiClient\Config\Api;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * Api config.
     * @var array
     */
    protected $api = [
        'baseUri' => 'https://devpub-api.dbd.net/api/v1',
        'apiToken' => '1234567890abcdefghijklmnopqrstuvwxyz',
    ];

    /**
     * Make mock Guzzle response.
     * @param int $status
     * @param array $headers
     * @param string $response
     * @return \GuzzleHttp\Handler\MockHandler
     */
    protected function makeHandler(int $status = 200, array $headers = [], string $response = null) : MockHandler
    {
        return new MockHandler([
            new Response($status, $headers, $response),
        ]);
    }

    /**
     * Test can instanciate client
     */
    public function testCanInstanciateClient()
    {
        $client = new Client(new Api($this->api));
        $this->assertInstanceOf('Gamebetr\ApiClient\Client', $client);
    }

    /**
     * Test can init client
     */
    public function testCanInitClient()
    {
        $client = Client::init(Api::init($this->api));
        $this->assertInstanceOf('Gamebetr\ApiClient\Client', $client);
    }
}
