<?php

namespace Gamebetr\ApiClient;

use stdClass;

class ApiObject
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
     * @var /stdClass $object
     * @return void
     */
    public function __construct(stdClass $object = null)
    {
        $this->parseObject($object);
    }

    /**
     * Static constructor.
     * @var /stdClass $object
     * @return self
     */
    public static function init(stdClass $object = null) : self
    {
        return new static($object);
    }

    /**
     * Parse object.
     * @paray \stdClass $object
     * @return self
     */
    public function parseObject(stdClass $object = null) : self
    {
        if (isset($object->data)) {
            $object = $object->data;
        }
        if (isset($object->id)) {
            $this->id = $object->id;
        }
        if (isset($object->type)) {
            $this->type = $object->type;
        }
        if (isset($object->attributes)) {
            $this->attributes = (array) $object->attributes;
        }
        if (isset($object->relationships)) {
            foreach ($object->relationships as $relation => $data) {
                $this->relationships[$relation] = new static($data);
            }
        }
        if (isset($object->links)) {
            foreach ($object->links as $link => $data) {
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
}
