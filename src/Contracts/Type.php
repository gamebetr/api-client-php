<?php

namespace Gamebetr\ApiClient\Contracts;

interface Type
{

    /**
     * Class constructor.
     * @param mixed $initData
     * @return void
     */
    public function __construct($initData = null);

    /**
     * Static constructor.
     * @param mixed $initData
     * @return self
     */
    public static function init($initData = null) : self;

    /**
     * Parse data.
     * @param mixed $data
     * @return self
     */
    public function parseData($data = null) : self;

    /**
     * Magic getter.
     * @param $name
     * @return mixed
     */
    public function __get($name);

    /**
     * Magic setter.
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value);

    /**
     * Methods.
     * @return array
     */
    public function methods() : array;

    /**
     * Method.
     * @param string $method
     * @return array
     */
    public function method(string $method) : array;
}
