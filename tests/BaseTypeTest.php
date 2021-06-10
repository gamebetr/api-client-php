<?php

declare(strict_types=1);

namespace Gamebetr\ApiClient\Tests;

use Gamebetr\ApiClient\Abstracts\BaseType;
use Gamebetr\ApiClient\Types\Collection;
use PHPUnit\Framework\TestCase;

class BaseTypeTest extends TestCase
{
    public function test_parseData_array(): void
    {
        $cls = new class() extends BaseType {
            public $type = 'MockClass';
        };

        $attr = [
            'foo' => 'bar',
            'fizz' => 'buzz',
            'arr' => ['foo', 'bar', 'fizz', 'buzz'],
            'num' => 1234.5,
        ];

        $type = $cls::init([
            'id' => 'test',
            'type' => 'FooBar',
            'attributes' => $attr,
        ]);
        self::assertEquals('test', $type->id);
        self::assertEquals('MockClass', $type->type);
        self::assertEquals($attr, $type->attributes['attributes']);
    }

    public function test_unset_type_gets_set(): void
    {
        $cls = new class() extends BaseType {
        };
        $type = $cls::init(
            (object)[
                'type' => 'FizzBuzz',
            ]
        );
        self::assertEquals('FizzBuzz', $type->type);
    }

    /**
     * @depends test_unset_type_gets_set
     */
    public function test_set_type_remains_set(): void
    {
        $cls = new class() extends BaseType {
            public $type = 'MockClass';
        };
        $type = $cls::init(
            (object)[
                'type' => 'FizzBuzz',
            ]
        );
        self::assertEquals('MockClass', $type->type);
    }

    public function test_nested_data_overwrites_parent_data(): void
    {
        $cls = new class() extends BaseType {
        };

        $data = (object)[
            'attributes' => ['level' => 'parent'],
            'data' => (object)['attributes' => ['level' => 'child']],
        ];

        $type = $cls::init($data);
        self::assertEquals('child', $type->attributes['level']);
    }

    /**
     * @depends test_nested_data_overwrites_parent_data
     */
    public function test_nested_data_attributes_array_ignored(): void
    {
        $cls = new class() extends BaseType {
        };

        $data = (object)[
            'attributes' => ['level' => 'parent'],
            'data' => ['attributes' => ['level' => 'child']],
        ];

        $type = $cls::init($data);
        self::assertArrayNotHasKey('level', $type->attributes);
    }

    public function test_tested_data_attributes_cast_to_array(): void
    {
        $cls = new class() extends BaseType {
        };

        $data = (object)[
            'attributes' => (object)['fizz' => 'buzz'],
        ];

        $type = $cls::init($data);
        self::assertIsArray($type->attributes);
        self::assertEquals('buzz', $type->attributes['fizz']);
    }

    public function dataProviderRelationshipKeys(): array
    {
        return [
            ['included'],
            ['related'],
            ['relationships'],
        ];
    }

    /**
     * @dataProvider dataProviderRelationshipKeys
     *
     * @param string $subkey
     */
    public function test_subkeys_map_to_mainkey(string $subkey): void
    {
        $cls = new class() extends BaseType {
        };

        $data = (object)[
            $subkey => [
                'images' => [
                    ['type' => 'generic', 'id' => 'foo'],
                    ['type' => 'generic', 'id' => 'bar'],
                ],
            ],
        ];

        $type = $cls::init($data);
        self::assertNotEmpty($type->relationships);
        self::assertInstanceOf(Collection::class, $type->relationships['images']);
    }

    public function test_links_map_to_links(): void
    {
        $cls = new class() extends BaseType {
        };

        $links = [
            'foo ' => 'http://example.com',
            'bar ' => 'http://example.com',
        ];

        $data = (object)[
            'links' => $links,
        ];

        $type = $cls::init($data);
        self::assertEquals($links, $type->links);
    }
}
