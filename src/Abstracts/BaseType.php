<?php

namespace Gamebetr\ApiClient\Abstracts;

use Gamebetr\ApiClient\Contracts\Type;
use Gamebetr\ApiClient\Exceptions\InvalidMethod;
use Gamebetr\ApiClient\Utility\Type as UtilityType;

abstract class BaseType implements Type
{
    /**
     * Type.
     * @var string
     */
    public $type;

    /**
     * Id.
     * @var string
     */
    public $id;

    /**
     * Attributes.
     * @var array
     */
    public $attributes = [];

    /**
     * Relationships.
     * @var array
     */
    public $relationships = [];

    /**
     * Links.
     * @var array
     */
    public $links = [];

    /**
     * Class constructor.
     * @param mixed $initData
     * @return void
     */
    public function __construct($initData = null)
    {
        $this->parseData($initData);
    }

    /**
     * Static constructor.
     * @param mixed $initData
     * @return self
     */
    public static function init($initData = null) : self
    {
        return new static($initData);
    }

    /**
     * Parse data.
     * @param mixed $data
     * @return self
     */
    public function parseData($data = null) : self
    {
        if (is_array($data)) {
            $this->attributes = $data;
            return $this;
        }
        if (isset($data->data)) {
            $data = $data->data;
        }
        if (isset($data->id)) {
            $this->id = $data->id;
        }
        if (isset($data->type)) {
            $this->type = $data->type;
        }
        if (isset($data->attributes)) {
            $this->attributes = (array) $data->attributes;
        }
        if (isset($data->relationships)) {
            foreach ($data->relationships as $relation => $data) {
                $this->relationships[$relation] = UtilityType::make($data);
            }
        }
        if (isset($data->links)) {
            foreach ($data->links as $link => $data) {
                $this->links[$link] = $data;
            }
        }

        return $this;
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
     * Magic method caller.
     * @param string $name
     * @param array $arguments
     * @return array
     */
    public function __call($name, $arguments)
    {
        if (!isset($this->methods[$name])) {
            throw new InvalidMethod();
        }
        return $this->methods[$name];
    }
}
