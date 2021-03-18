<?php

namespace Gamebetr\ApiClient\Exceptions;

use Gamebetr\ApiClient\Abstracts\BaseException;

class MissingParameter extends BaseException
{
    /**
     * Message.
     * @var string
     */
    protected $message = 'Missing required parameter';

    /**
     * Code.
     * @var int
     */
    protected $code = 422;
}
