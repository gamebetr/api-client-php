<?php

namespace Gamebetr\ApiClient\Contracts;

use Gamebetr\ApiClient\Request;

interface ApiContract
{
    /**
     * Get all attributes.
     * @return array
     */
    public function getAttributes() : array;

    /**
     * Get URL.
     * @param string $endpoint
     * @return string
     */
    public function getUrl(string $endpoint) : string;

    /**
     * Get authorization.
     * @return array
     */
    public function getAuthorization() : array;

    /**
     * Allowed methods.
     * @return array
     */
    public function allowedMethods() : array;

    /**
     * Request.
     * @param string $endpoint
     * @param string $method
     * @param array $parameters
     * @param bool $requiresAuth
     * @param array $headers
     * @param array $query
     * @return \Gamebetr\ApiClient\Request
     */
    public function request(
        string $endpoint,
        string $method = 'GET',
        array $parameters = [],
        bool $requiresAuth = true,
        array $headers = []
    ) : Request;
}
