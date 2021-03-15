<?php

namespace Gamebetr\ApiClient\Config;

use Gamebetr\ApiClient\Abstracts\BaseConfig;

class Api extends BaseConfig
{
    /**
     * Config.
     * @var array
     */
    protected $config = [
        'baseUri' => 'https://api.gamebetr.com/api/v1',
        'apiToken' => null,
    ];
}
