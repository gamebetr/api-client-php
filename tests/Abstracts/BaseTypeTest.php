<?php

declare(strict_types=1);

namespace Gamebetr\ApiClient\Tests\Abstracts;

use Gamebetr\ApiClient\Abstracts\BaseType;
use Gamebetr\ApiClient\Types\Collection;
use Gamebetr\ApiClient\Types\Game;
use Gamebetr\ApiClient\Utility\Type;
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

    public function test_simulated_response_converts_as_expected(): void
    {
        // <editor-fold desc="raw json string">
        $data = '{
   "data":[
      {
         "type":"game",
         "id":"394460ed-7498-4cfb-90f1-975572dce831",
         "attributes":{
            "launch_id":"fizzbuzz-3074823",
            "provider_integer_id":8127812,
            "provider_id":"fizzbuzz",
            "provider_name":"fizzbuzz",
            "provider_description":"fizzbuzz provided by fizzbuzz",
            "game_id":"3074823",
            "game_name":" randolph-the-plumber",
            "game_description":" randolph-the-plumber",
            "aspect_ratio":null,
            "mobile_ready":true,
            "active":true,
            "launch_count":6,
            "transaction_count":0,
            "win_count":0,
            "hit_percent":"0.00",
            "win_loss":"0.00000000",
            "updated_at":"2021-06-10T14:02:13+00:00",
            "created_at":"2021-02-25T16:32:22+00:00"
         },
         "tags":[
            "of",
            "fizzbuzz",
            "the",
            "randolph",
            "plumber"
         ],
         "related":{
            "images":[
               {
                  "type":"image",
                  "id":"13bce435-87cd-46f1-9d18-c111e0015c4c",
                  "attributes":{
                     "type":"image",
                     "filename":"13bce435-87cd-46f1-9d18-c111e0015c4c",
                     "extension":"png",
                     "updated_at":"2021-03-01T13:58:09+00:00",
                     "created_at":"2021-03-01T13:58:09+00:00"
                  },
                  "links":{
                     "original":"https:\\/\\/example.com\\/image\\/13bce435-87cd-46f1-9d18-c111e0015c4c.png",
                     "100x100":"https:\\/\\/example.com\\/image\\/13bce435-87cd-46f1-9d18-c111e0015c4c_100x100.png",
                     "200x200":"https:\\/\\/example.com\\/image\\/13bce435-87cd-46f1-9d18-c111e0015c4c_200x200.png"
                  }
               }
            ],
            "tags":[
               {
                  "type":"tag",
                  "id":"045e2bfd-123a-4c3b-54cb-7aa0e873f4ce",
                  "attributes":{"name":"of"},
                  "related":[]
               },
               {
                  "type":"tag",
                  "id":"739c0d29-86ea-41d1-867e-bf1de79116c7",
                  "attributes":{"name":"fizzbuzz"},
                  "related":[]
               },
               {
                  "type":"tag",
                  "id":"045e2bfd-7284-40a0-b07f-3a3f9ee1522f",
                  "attributes":{"name":"the"},
                  "related":[]
               },
               {
                  "type":"tag",
                  "id":"2556b78a-40a0-7284-abb8-7aa0e873f4ce",
                  "attributes":{"name":"randolph"},
                  "related":[]
               },
               {
                  "type":"tag",
                  "id":"92140acc-127a-4511-af30-bf1de79116c7",
                  "attributes":{"name":"plumber"},
                  "related":[]
               }
            ]
         }
      },
      {
         "type":"game",
         "id":"045e2bfd-51dd-489a-af30-89dd9061c53b",
         "attributes":{
            "launch_id":"fizzbuzz-1231451",
            "provider_integer_id":8127812,
            "provider_id":"fizzbuzz",
            "provider_name":"fizzbuzz",
            "provider_description":"fizzbuzz provided by fizzbuzz",
            "game_id":"1231451",
            "game_name":" ryan-goes-to-the-grocery-store",
            "game_description":" ryan-goes-to-the-grocery-store",
            "aspect_ratio":null,
            "mobile_ready":true,
            "active":true,
            "launch_count":6,
            "transaction_count":0,
            "win_count":0,
            "hit_percent":"0.00",
            "win_loss":"0.00000000",
            "updated_at":"2021-06-10T11:30:43+00:00",
            "created_at":"2021-02-25T16:32:22+00:00"
         },
         "tags":[
            "fizzbuzz",
            "the",
            "ryan",
            "goes",
            "to",
            "store",
            "grocery"
         ],
         "related":{
            "images":[
               {
                  "type":"image",
                  "id":"939c0d29-abc1-484f-a3cf-4c58ca802e8b",
                  "attributes":{
                     "type":"image",
                     "filename":"939c0d29-abc1-484f-a3cf-4c58ca802e8b",
                     "extension":"png",
                     "updated_at":"2021-03-01T13:58:09+00:00",
                     "created_at":"2021-03-01T13:58:09+00:00"
                  },
                  "links":{
                     "original":"https:\\/\\/example.com\\/image\\/939c0d29-abc1-484f-a3cf-4c58ca802e8b.png",
                     "100x100":"https:\\/\\/example.com\\/image\\/939c0d29-abc1-484f-a3cf-4c58ca802e8b_100x100.png",
                     "200x200":"https:\\/\\/example.com\\/image\\/939c0d29-abc1-484f-a3cf-4c58ca802e8b_200x200.png"
                  }
               }
            ],
            "tags":[
               {
                  "type":"tag",
                  "id":"d3a59f5f-86ea-41d1-867e-267233d8f5f9",
                  "attributes":{"name":"fizzbuzz"},
                  "related":[]
               },
               {
                  "type":"tag",
                  "id":"045e2bfd-7284-40a0-b07f-22640742d98e",
                  "attributes":{"name":"the"},
                  "related":[]
               },
               {
                  "type":"tag",
                  "id":"dd32b3ba-cf82-4d83-b948-030692b46219",
                  "attributes":{"name":"ryan"},
                  "related":[]
               },
               {
                  "type":"tag",
                  "id":"c4ed6cd0-bb32-4e67-9acd-d6277f37f4c9",
                  "attributes":{"name":"goes"},
                  "related":[]
               },
               {
                  "type":"tag",
                  "id":"c4ed6cd0-6436-4ec1-a946-030692b46219",
                  "attributes":{"name":"to"},
                  "related":[]
               },
               {
                  "type":"tag",
                  "id":"045e2bfd-f231-4372-9b68-22640742d98e",
                  "attributes":{"name":"grocery"},
                  "related":[]
               },
               {
                  "type":"tag",
                  "id":"d3a59f5f-5d09-4522-a6ac-267233d8f5f9",
                  "attributes":{"name":"store"},
                  "related":[]
               }
            ]
         }
      }
   ]
}';
        // </editor-fold>

        $expected_tags = [
            '045e2bfd-123a-4c3b-54cb-7aa0e873f4ce' => 'of',
            '739c0d29-86ea-41d1-867e-bf1de79116c7' => 'fizzbuzz',
            '045e2bfd-7284-40a0-b07f-3a3f9ee1522f' => 'the',
            '2556b78a-40a0-7284-abb8-7aa0e873f4ce' => 'randolph',
            '92140acc-127a-4511-af30-bf1de79116c7' => 'plumber',
        ];

        /** @var Collection $games */
        $games = Type::make($data);
        self::assertInstanceOf(Collection::class, $games);
        self::assertCount(2, $games->items);

        /** @var Game $game */
        $game = $games->first();

        self::assertEquals('394460ed-7498-4cfb-90f1-975572dce831', $game->id);
        self::assertInstanceOf(Collection::class, $game->relationships['tags']);
        self::assertCount(count($expected_tags), $game->relationships['tags']->items);

        /** @var Collection $tags */
        $tags = $game->relationships['tags'];

        self::assertCount(0, array_diff(array_keys($expected_tags), array_keys($tags->items)));
        $names = array_column(array_column($tags->items, 'attributes'), 'name');
        self::assertCount(0, array_diff($expected_tags, $names));

        self::assertInstanceOf(Collection::class, $game->relationships['images']);
        self::assertCount(1, $game->relationships['images']->items);

        $image = $game->relationships['images']->first();
        self::assertEquals('13bce435-87cd-46f1-9d18-c111e0015c4c', $image->id);
        self::assertEquals([
            'type' => 'image',
            'filename' => '13bce435-87cd-46f1-9d18-c111e0015c4c',
            'extension' => 'png',
            'updated_at' => '2021-03-01T13:58:09+00:00',
            'created_at' => '2021-03-01T13:58:09+00:00',
        ], $image->attributes);
        self::assertEquals([
            'original' => 'https://example.com/image/13bce435-87cd-46f1-9d18-c111e0015c4c.png',
            '100x100' => 'https://example.com/image/13bce435-87cd-46f1-9d18-c111e0015c4c_100x100.png',
            '200x200' => 'https://example.com/image/13bce435-87cd-46f1-9d18-c111e0015c4c_200x200.png',
        ], $image->links);
    }
}
