<?php

namespace Gamebetr\ApiClient\Abstracts;

use Gamebetr\ApiClient\Contracts\Type;
use Gamebetr\ApiClient\Exceptions\InvalidMethod;
use Gamebetr\ApiClient\Exceptions\MissingParameter;
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
     * Init data.
     * @var mixed
     */
    protected $initData;

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
    public function parseData($data = null): self
    {
        $this->initData = $data;

        if (empty($data)) {
            return $this;
        }

        if (is_array($data)) {
            $this->parseDataFromArray($data);

            return $this;
        }

        if (isset($data->data)) {
            $data = $data->data;
        }
        if (isset($data->id)) {
            $this->id = $data->id;
        }
        if (isset($data->type) && !$this->type) {
            $this->type = $data->type;
        }
        if (isset($data->attributes)) {
            $this->attributes = (array)$data->attributes;
        }

        $this->parseRelationships((object)$data);

        if (isset($data->links)) {
            $this->links = array_merge((array)$data->links, $this->links ?? []);
        }

        return $this;
    }

    /**
     * Parse various relationships from an object based set of data.
     *
     * @param object $data
     *   The data to parse.
     */
    protected function parseRelationships(object $data): void
    {
        foreach (['relationships', 'related', 'included'] as $key) {
            if (isset($data->{$key})) {
                foreach ($data->{$key} as $k => $v) {
                    $this->relationships[$k] = UtilityType::make($v);
                }
            }
        }
    }

    /**
     * Parses an array based set of data.
     *
     * @param array $data
     *   The data to parse.
     */
    protected function parseDataFromArray(array $data): void
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
            unset($data['id']);
        }

        // Preserve any existing attributes while adding new ones.
        $this->attributes = array_merge($data, $this->attributes);
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
        $method = $this->method($name);
        if (isset($method['required_parameters'])) {
            foreach ($method['required_parameters'] as $parameter) {
                if (!$this->$parameter) {
                    throw new MissingParameter('Missing required parameter '.$parameter);
                }
            }
        }
        $method['endpoint'] = $this->parseEndpoint($method['endpoint']);

        return $method;
    }

    /**
     * Methods.
     * @return array
     */
    public function methods() : array
    {
        return array_keys($this->methods);
    }

    /**
     * Method.
     * @param string $method
     * @return array
     */
    public function method(string $method) : array
    {
        if (!isset($this->methods[$method])) {
            throw new InvalidMethod();
        }

        return $this->methods[$method];
    }

    /**
     * Get init data.
     * @return mixed
     */
    public function getInitData()
    {
        return $this->initData;
    }

    /**
     * Parse endpoint
     * @param string $endpoint
     * @return string
     */
    private function parseEndpoint(string $endpoint) : string
    {
        $replacements = [
            '{id}' => $this->id,
            '{id?}' => $this->id,
            '{type}' => $this->type,
            '{type?}' => $this->type,
        ];
        foreach ($this->attributes as $attribute => $value) {
            $replacements['{'.$attribute.'}'] = $value;
            $replacements['{'.$attribute.'?}'] = $value;
        }
        $endpoint = strtr($endpoint, $replacements);
        $endpoint = preg_replace('/\{.*\?\}/', '', $endpoint);

        return $endpoint;
    }
}
