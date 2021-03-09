<?php

namespace Gamebetr\ApiClient\Contracts;

use stdClass;

interface RequestContract
{
    /**
     * Class constructor.
     * @param \Gamebetr\ApiClient\Contracts\ApiContract $api
     * @return void
     */
    public function __construct(ApiContract $api);

    /**
     * Static constructor.
     * @param \Gamebetr\ApiClient\Contracts\ApiContract $api
     * @return self
     */
    public static function init(ApiContract $api) : self;

    /**
     * Set method.
     * @param string $method
     * @return self
     */
    public function method(string $method) : self;

    /**
     * Set requiresAuth.
     * @param bool $value
     * @return self
     */
    public function requiresAuth(bool $value) : self;

    /**
     * Set headers.
     * @param array $headers
     * @return self
     */
    public function headers(array $headers) : self;

    /**
     * Set header.
     * @param string $header
     * @param string $value
     * @return self
     */
    public function header(string $header, string $value) : self;

    /**
     * Set parameters.
     * @param array $parameters
     * @return self
     */
    public function parameters(array $parameters) : self;

    /**
     * Set parameter.
     * @param string $parameter
     * @param mixed $value
     * @return self
     */
    public function parameter(string $parameter, $value) : self;

    /**
     * Set query.
     * @param array $query
     * @return self
     */
    public function query(array $query = null) : self;

    /**
     * Make request.
     * @param string $endpoint
     * @return self
     */
    public function request(string $endpoint) : self;

    /**
     * Get status.
     * @return int
     */
    public function getStatus() : int;

    /**
     * Get reason.
     * @return string|null
     */
    public function getReason() : ?string;

    /**
     * Get response.
     * @return \stdClass|null
     */
    public function getResponse() : ?stdClass;
}
