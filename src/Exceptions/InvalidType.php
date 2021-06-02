<?php

namespace Gamebetr\ApiClient\Exceptions;

use Gamebetr\ApiClient\Abstracts\BaseException;

class InvalidType extends BaseException
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Invalid type';

    /**
     * Code.
     * @var int
     */
    protected $code = 422;
}
