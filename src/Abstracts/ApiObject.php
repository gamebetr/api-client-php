<?php

namespace Gamebetr\ApiClient\Abstracts;

use Gamebetr\ApiClient\Contracts\ApiContract;
use stdClass;

abstract class ApiObject
{
    /**
     * Api object.
     * @var \Gamebetr\ApiClient\Contracts\ApiContract
     */
    public $api;

    /**
     * Attributes.
     * @var array
     */
    public $attributes;

    /**
     * Class constructor.
     * @param \Gamebetr\ApiClient\Contracts\ApiContract $api
     * @param \stdClass $object
     * @return void
     */
    public function __construct(ApiContract $api, stdClass $object = null)
    {
        $this->api = $api;
        if ($object) {
            $this->fill($object);
        }
    }

    /**
     * Static constructor.
     * @param \Gamebetr\ApiClient\Contracts\ApiContract $api
     * @param \stdClass $object
     * @return self
     */
    public static function init(ApiContract $api, stdClass $object = null) : self
    {
        return new static($api, $object);
    }

    /**
     * Magic getter.
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (! isset($this->attributes[$name])) {
            return;
        }

        return $this->attributes[$name];
    }

    /**
     * Magic setter.
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Fill.
     * @param \stdClass $object
     * @return self
     */
    public function fill(stdClass $object) : self
    {
        if (! isset($object->id) || ! isset($object->attributes)) {
            return $this;
        }
        $this->id = $object->id;
        foreach ($object->attributes as $attribute => $value) {
            $this->$attribute = $value;
        }

        return $this;
    }

    /**
     * Exists.
     * @return bool
     */
    public function exists() : bool
    {
        return isset($this->id);
    }

    /**
     * Get attributes.
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }
}
