<?php

declare(strict_types=1);

namespace Gamebetr\ApiClient\Tests\Abstracts;

use Gamebetr\ApiClient\Types\Bank;
use Gamebetr\ApiClient\Types\Collection;
use Gamebetr\ApiClient\Types\Currency;
use Gamebetr\ApiClient\Utility\Type as UtilityType;
use PHPUnit\Framework\TestCase;

class JsonApiTypeTest extends TestCase
{
    public function test_jsonapi_maps_relationship_to_includes(): void
    {
        // <editor-fold desc="raw json string">
        $data = '{
   "data":[
      {
         "type":"banks",
         "id":"8e22a4e2-046e-4555-a668-b569a41c0102",
         "attributes":{
            "name":"Prof. Judah Macejkovic",
            "description":"Ut omnis sequi autem est repellendus illo.",
            "hidden":false,
            "transferable":false,
            "relaxed-balances":true,
            "created-at":"2021-06-13T06:05:54+00:00",
            "updated-at":"2021-06-13T06:05:54+00:00",
            "deleted-at":null
         },
         "relationships":{
            "currency":{
               "data":{
                  "type":"currencies",
                  "id":"dc633e41-ed07-4989-a1e9-3d5ecc3d9771"
               },
               "links":{
                  "self":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102\\/relationships\\/currency",
                  "related":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102\\/currency"
               }
            },
            "display-currency":{
               "links":{
                  "self":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102\\/relationships\\/display-currency",
                  "related":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102\\/display-currency"
               }
            },
            "tags":{
               "data":[
                  {
                     "type":"tags",
                     "id":"38e242b4-d43d-4e6e-a9c5-f46a6ad31062"
                  },
                  {
                     "type":"tags",
                     "id":"2aa35bcb-edfa-467b-857a-77ebcc5d0c70"
                  },
                  {
                     "type":"tags",
                     "id":"e9e80865-71ee-4e50-a80e-25fab7542519"
                  }
               ],
               "links":{
                  "self":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102\\/relationships\\/tags",
                  "related":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102\\/tags"
               }
            },
            "bank-accounts":{
               "links":{
                  "self":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102\\/relationships\\/bank-accounts",
                  "related":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102\\/bank-accounts"
               }
            },
            "notes":{
               "links":{
                  "self":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102\\/relationships\\/notes",
                  "related":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102\\/notes"
               }
            }
         },
         "links":{
            "self":"\\/api\\/v1\\/banks\\/8e22a4e2-046e-4555-a668-b569a41c0102"
         }
      }
   ],
   "included":[
      {
         "type":"currencies",
         "id":"dc633e41-ed07-4989-a1e9-3d5ecc3d9771",
         "attributes":{
            "name":"esse",
            "display-unit":"mollitia",
            "display-only":false,
            "issuance":"crypto",
            "multiplier":4524906,
            "created-at":"2021-06-13T06:05:54+00:00",
            "updated-at":"2021-06-13T06:05:54+00:00"
         }
      },
      {
         "type":"tags",
         "id":"38e242b4-d43d-4e6e-a9c5-f46a6ad31062",
         "attributes":{
            "name":"Bar",
            "created-at":"2021-06-13T06:05:54+00:00",
            "updated-at":"2021-06-13T06:05:54+00:00"
         },
         "relationships":{
            "vocabulary":{
               "links":{
                  "self":"\\/api\\/v1\\/tags\\/38e242b4-d43d-4e6e-a9c5-f46a6ad31062\\/relationships\\/vocabulary",
                  "related":"\\/api\\/v1\\/tags\\/38e242b4-d43d-4e6e-a9c5-f46a6ad31062\\/vocabulary"
               }
            }
         }
      },
      {
         "type":"tags",
         "id":"2aa35bcb-edfa-467b-857a-77ebcc5d0c70",
         "attributes":{
            "name":"Buzz",
            "created-at":"2021-06-13T06:05:54+00:00",
            "updated-at":"2021-06-13T06:05:54+00:00"
         },
         "relationships":{
            "vocabulary":{
               "links":{
                  "self":"\\/api\\/v1\\/tags\\/2aa35bcb-edfa-467b-857a-77ebcc5d0c70\\/relationships\\/vocabulary",
                  "related":"\\/api\\/v1\\/tags\\/2aa35bcb-edfa-467b-857a-77ebcc5d0c70\\/vocabulary"
               }
            }
         }
      },
      {
         "type":"tags",
         "id":"e9e80865-71ee-4e50-a80e-25fab7542519",
         "attributes":{
            "name":"Bazz",
            "created-at":"2021-06-13T06:05:54+00:00",
            "updated-at":"2021-06-13T06:05:54+00:00"
         },
         "relationships":{
            "vocabulary":{
               "links":{
                  "self":"\\/api\\/v1\\/tags\\/e9e80865-71ee-4e50-a80e-25fab7542519\\/relationships\\/vocabulary",
                  "related":"\\/api\\/v1\\/tags\\/e9e80865-71ee-4e50-a80e-25fab7542519\\/vocabulary"
               }
            }
         }
      }
   ]
}';
        // </editor-fold>

        $expected_tags = [
            '38e242b4-d43d-4e6e-a9c5-f46a6ad31062' => 'Bar',
            '2aa35bcb-edfa-467b-857a-77ebcc5d0c70' => 'Buzz',
            'e9e80865-71ee-4e50-a80e-25fab7542519' => 'Bazz',
        ];

        /** @var Collection $collection */
        $collection = UtilityType::make($data);

        self::assertCount(1, $collection->items);

        /** @var Bank $bank */
        $bank = $collection->first();
        self::assertEquals('8e22a4e2-046e-4555-a668-b569a41c0102', $bank->id);
        self::assertEquals('Prof. Judah Macejkovic', $bank->attributes['name']);
        self::assertCount(2, $bank->relationships);

        /** @var Collection $tags */
        $tags = $bank->relationships['tags'];

        self::assertInstanceOf(Collection::class, $tags);
        self::assertCount(count($expected_tags), $tags->items);
        self::assertCount(0, array_diff(array_keys($expected_tags), array_keys($tags->items)));
        $names = array_column(array_column($tags->items, 'attributes'), 'name');
        self::assertCount(0, array_diff($expected_tags, $names));

        self::assertInstanceOf(Collection::class, $bank->relationships['currency']);
        self::assertCount(1, $bank->relationships['currency']->items);

        /** @var Currency $currency */
        $currency = $bank->relationships['currency']->first();
        self::assertEquals('dc633e41-ed07-4989-a1e9-3d5ecc3d9771', $currency->id);
        self::assertEquals([
            'name' => 'esse',
            'display-unit' => 'mollitia',
            'display-only' => null,
            'issuance' => 'crypto',
            'multiplier' => 4524906,
            'created-at' => '2021-06-13T06:05:54+00:00',
            'updated-at' => '2021-06-13T06:05:54+00:00',
        ], $currency->attributes);
    }

}
