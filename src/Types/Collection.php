<?php

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Contracts\Type;
use Gamebetr\ApiClient\Exceptions\InvalidMethod;
use Gamebetr\ApiClient\Utility\Type as UtilityType;

class Collection implements Type
{
    /**
     * Type.
     * @var string
     */
    public $type = 'collection';

    /**
     * Items.
     * @var array
     */
    public $items = [];

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
        if (! is_array($data)) {
            return $this;
        }
        foreach ($data as $item) {
            $type = UtilityType::make($item);
            if (isset($type->id)) {
                $this->items[$type->id] = $type;
            } else {
                $this->items[] = $type;
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
        if (! isset($this->items[$name])) {
            return;
        }

        return $this->items[$name];
    }

    /**
     * Magic setter.
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->items[$name] = $value;
    }

    /**
     * Magic method caller.
     * @param string $name
     * @param array $arguments
     * @return array
     */
    public function __call($name, $arguments)
    {
        if (! isset($this->methods[$name])) {
            throw new InvalidMethod();
        }

        return $this->methods[$name];
    }

    /**
     * Methods.
     * @return array
     */
    public function methods() : array
    {
        return [];
    }

    /**
     * Method.
     * @param string $method
     * @return array
     */
    public function method(string $method) : array
    {
        throw new InvalidMethod();
    }

    /**
     * First.
     * @return Gamebetr\ApiClient\Contracts\Type|null
     */
    public function first() : ?Type
    {
        return reset($this->items);
    }

    /**
     * Current.
     * @return Gamebetr\ApiClient\Contracts\Type|null
     */
    public function current() : ?Type
    {
        return current($this->items);
    }

    /**
     * Next.
     * @return Gamebetr\ApiClient\Contracts\Type|null
     */
    public function next() : ?Type
    {
        return next($this->items);
    }

    /**
     * Prev.
     * @return Gamebetr\ApiClient\Contracts\Type|null
     */
    public function prev() : ?Type
    {
        return prev($this->items);
    }
    
    /**
     * Last.
     * @return Gamebetr\ApiClient\Contracts\Type|null
     */
    public function last() : ?Type
    {
        return end($this->items);
    }
}
