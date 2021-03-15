<?php

namespace Gamebetr\ApiClient\Exceptions;

use Exception;
use Throwable;

class UnknownType extends Exception
{
    /**
     * Class constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     * @return void
     */
    public function __construct(string $message = 'Unknown type', int $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
