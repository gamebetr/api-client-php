<?php

namespace Gamebetr\ApiClient\Exceptions;

use Gamebetr\ApiClient\Abstracts\BaseException;

class InvalidApi extends BaseException
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Invalid API';

    /**
     * Code.
     * @var int
     */
    protected $code = 500;
}
