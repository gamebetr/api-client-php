<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Contracts\ApiContract;

class Api implements ApiContract
{
    /**
     * Attributes.
     * @var array
     */
    private $attributes = [
        'baseUri' => 'https://api.gamebetr.com/api/v1',
        'apiToken' => null,
        'allowedMethods' => [
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
        ],
    ];

    /**
     * Class constructor.
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            $this->attributes[$attribute] = $value;
        }
    }

    /**
     * Static constructor.
     * @param array $attributes
     * @return self
     */
    public static function init(array $attributes = []) : self
    {
        return new static($attributes);
    }

    /**
     * Attribute setter.
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Attribute getter.
     * @param $name
     * @return $mixed
     */
    public function __get($name)
    {
        if (! isset($this->attributes[$name])) {
            return;
        }

        return $this->attributes[$name];
    }

    /**
     * Get all attributes.
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * Get URL.
     * @param string $endpoint
     * @return string
     */
    public function getUrl(string $endpoint) : string
    {
        return rtrim($this->baseUri, '/').'/'.ltrim($endpoint, '/');
    }

    /**
     * Get authorization.
     * @return array
     */
    public function getAuthorization() : array
    {
        $headers = [];
        if ($apiToken = $this->apiToken) {
            $headers['Authorization'] = 'Bearer '.$apiToken;
        }

        return $headers;
    }

    /**
     * Allowed methods.
     * @return array
     */
    public function allowedMethods() : array
    {
        return $this->allowedMethods;
    }
}
