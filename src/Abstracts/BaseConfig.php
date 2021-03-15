<?php

namespace Gamebetr\ApiClient\Abstracts;

use Gamebetr\ApiClient\Contracts\Config;

abstract class BaseConfig implements Config
{
    /**
     * Config.
     * @var array
     */
    protected $config = [];

    /**
     * Class constructor.
     * @var array $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $parameter => $value) {
            $this->config[$parameter] = $value;
        }
    }

    /**
     * Static constructor.
     * @var array $config
     * @return self
     */
    public static function init(array $config = []) : self
    {
        return new static($config);
    }

    /**
     * Config setter.
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->config[$name] = $value;
    }

    /**
     * Config getter.
     * @param $name
     * @return $mixed
     */
    public function __get($name)
    {
        if (! isset($this->config[$name])) {
            return;
        }

        return $this->config[$name];
    }

    /**
     * Get full config.
     * @return array
     */
    public function getConfig() : array
    {
        return $this->config;
    }
}
