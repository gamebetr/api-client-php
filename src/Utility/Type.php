<?php

namespace Gamebetr\ApiClient\Utility;

use Gamebetr\ApiClient\Config\Types;
use Gamebetr\ApiClient\Contracts\Type as TypeContract;
use Gamebetr\ApiClient\Types\Collection;
use Gamebetr\ApiClient\Types\Error;
use Gamebetr\ApiClient\Types\Generic;

class Type
{
    /**
     * Make
     * @param mixed $data
     * @return \Gamebetr\ApiClient\Contracts\Type
     */
    public static function make($data) : TypeContract
    {
        // Try to decode json data
        if (is_string($data)) {
            $data = json_decode($data);
        }
        if (is_array($data)) {
            $data = json_decode(json_encode($data));
        }
        if (!is_object($data)) {
            return new Error([
                'message' => 'Could not decode data',
            ]);
        }
        if (isset($data->data)) {
            $data = $data->data;
        }
        $type = null;
        if (isset($data->type)) {
            $type = Types::init()->{$data->type};
        }
        if (is_array($data)) {
            $type = Collection::class;
        }
        if (!$type) {
            $type = Generic::class;
        }
        return $type::init($data);
    }
}
