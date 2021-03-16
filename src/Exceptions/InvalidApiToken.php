<?php

namespace Gamebetr\ApiClient\Exceptions;

use Gamebetr\ApiClient\Abstracts\BaseException;

class InvalidApiToken extends BaseException
{
    /**
     * Message.
     * @var string
     */
    protected string $message = 'Invalid API token';

    /**
     * Code.
     * @var int
     */
    protected int $code = 401;
}