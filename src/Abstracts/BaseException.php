<?php

namespace Gamebetr\ApiClient\Abstracts;

use Exception;
use Throwable;

abstract class BaseException extends Exception
{
    /**
     * Message.
     * @var string
     */
    protected $message = '';

    /**
     * Code.
     * @var int
     */
    protected $code = 0;

    /**
     * Class constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     * @return void
     */
    public function __construct(string $message = null, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $message ?? $this->message,
            $code ?? $this->code,
            $previous
        );
    }
}
