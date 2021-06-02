<?php

namespace Gamebetr\ApiClient\Exceptions;

use Gamebetr\ApiClient\Abstracts\BaseException;

class InvalidApiToken extends BaseException
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Invalid API token';

    /**
     * Code.
     * @var int
     */
    protected $code = 401;
}
