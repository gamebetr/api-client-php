<?php

namespace Gamebetr\ApiClient\Utility;

use Gamebetr\ApiClient\Config\Types;
use Gamebetr\ApiClient\Contracts\Type as TypeContract;
use Gamebetr\ApiClient\Types\Collection;
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

        $data = self::unrollData($data);

        $type = null;
        if (isset($data->type)) {
            $type = Types::init()->{$data->type};
        }
        if (is_array($data)) {
            $type = Collection::class;
        }
        if (! $type) {
            $type = Generic::class;
        }

        return $type::init($data);
    }

    /**
     * List
     * @return array
     */
    public static function list() : array
    {
        return array_values(array_unique(Types::init()->getConfig()));
    }

    /**
     * Unroll nested data properties.
     *
     * Preserves top level special keys for processing by individual types.
     *
     * @param $data
     *   The data that might have a nested data property.
     * @param int $maxDepth
     *   The maxiumum depth to unroll to.
     *
     * @return object|array
     *   The unrolled data with preserved special keys.
     */
    protected static function unrollData($data, int $maxDepth = 2)
    {
        $preserved = [];
        $unroll = 0;

        while (isset($data->data) && ($unroll++ < $maxDepth)) {
            // Yoink out our top-level special keys to assign to the final
            // unrolled data (or items in a data array).
            foreach (['links', 'included', 'meta'] as $key) {
                if (isset($data->{$key}) && !isset($preserved[$key])) {
                    $preserved[$key] = $data->{$key};
                }
            }

            $data = $data->data;
        }

        // Add our special items back in.
        foreach ($preserved as $key => $value) {
            // Our data may have been a list of documents instead of a single
            // document, so assign our special keys to each document so their
            // type handler can do whatever it needs.
            if (is_array($data)) {
                foreach (array_keys($data) as $idx) {
                    $data[$idx]->{$key} = $value;
                }
            }
            // We had a direct document so assign back in directly.
            else {
                $data->{$key} = $value;
            }
        }

        return $data;
    }
}
