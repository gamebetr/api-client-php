<?php

namespace Gamebetr\ApiClient\Tests;

use Gamebetr\ApiClient\Config\Api;
use PHPUnit\Framework\TestCase;

class ApiConfigTest extends TestCase
{
    /**
     * Test api config instanciation
     */
    public function testCanInstanciateApiConfig()
    {
        $api = new Api();
        $this->assertInstanceOf('Gamebetr\ApiClient\Contracts\Config', $api);
    }

    /**
     * Test api config init
     */
    public function testCanInitApiConfig()
    {
        $api = Api::init();
        $this->assertInstanceOf('Gamebetr\ApiClient\Contracts\Config', $api);
    }

    /**
     * Test can instanciate with data
     */
    public function testCanInstanciateApiConfigWithData()
    {
        $api = new Api(['key' => 'value']);
        $this->assertEquals('value', $api->key);
    }

    /**
     * Test can init with data
     */
    public function testCanInitApiConfigWithData()
    {
        $api = Api::init(['key' => 'value']);
        $this->assertEquals('value', $api->key);
    }

    /**
     * Test can access config array
     */
    public function testCanAccessApiConfigArray()
    {
        $api = Api::init();
        $this->assertIsArray($api->getConfig());
    }
}
