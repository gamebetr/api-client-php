<?php

namespace Gamebetr\ApiClientPhp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Gamebetr\ApiClientPhp\Services\ApiClientService init(array $attributes = [])
 * @method static \Gamebetr\ApiClientPhp\Services\ApiClientService setApiToken(string $apiToken = null)
 * @method static string|null getApiToken()
 * @method static \Gamebetr\ApiClientPhp\Services\ApiClientService setBaseUri(string $baseUri = null)
 * @method static string|null getBaseUri()
 * @method static \Gamebetr\ApiClientPhp\Services\ApiClientService setDomainId(int $domainId = null)
 * @method static int|null getDomainId()
 * @see \Gamebetr\ApiClientPhp\Services\ApiClientService
 */
class ApiClient extends Facade
{
    /**
     * Get facade accessor.
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'api-client-service';
    }
}
