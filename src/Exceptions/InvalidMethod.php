<?php

namespace Gamebetr\ApiClient\Exceptions;

use Gamebetr\ApiClient\Abstracts\BaseException;

class InvalidMethod extends BaseException
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Invalid method';

    /**
     * Code.
     * @var int
     */
    protected $code = 500;
}
