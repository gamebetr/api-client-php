<?php

namespace Gamebetr\ApiClient\Exceptions;

use Exception;
use Throwable;

class InvalidApiToken extends Exception
{
    /**
     * Class constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     * @return void
     */
    public function __construct(string $message = 'Invalid API token', int $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
