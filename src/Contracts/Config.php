<?php

namespace Gamebetr\ApiClient\Contracts;

interface Config
{
    /**
     * Class constructor.
     * @var array
     * @return void
     */
    public function __construct(array $config = []);

    /**
     * Static constructor.
     * @var array
     * @return self
     */
    public static function init(array $config = []) : self;

    /**
     * Config setter.
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value);

    /**
     * Config getter.
     * @param $name
     * @return $mixed
     */
    public function __get($name);

    /**
     * Get full config.
     * @return array
     */
    public function getConfig() : array;
}
