<?php

namespace Gamebetr\ApiClient\Contracts;

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
}
