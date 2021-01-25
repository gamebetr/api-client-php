<?php

namespace Gamebetr\ApiClient\Models;

use stdClass;

class User
{
    /**
     * Id.
     * @var string
     */
    public $id;

    /**
     * Name.
     * @var string
     */
    public $name;

    /**
     * Email.
     * @var string
     */
    public $email;

    /**
     * Class constructor.
     * @param \stdClass $user
     * @return void
     */
    public function __construct(stdClass $user = null)
    {
        if (! $user) {
            return;
        }
        if (isset($user->id)) {
            $this->id = $user->id;
        }
        if (! isset($user->attributes)) {
            return;
        }
        if (isset($user->attributes->name)) {
            $this->name = $user->attributes->name;
        }
        if (isset($user->attributes->email)) {
            $this->email = $user->attributes->email;
        }
    }
}
