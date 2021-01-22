<?php

namespace Gamebetr\ApiClient\Objects;

use Gamebetr\ApiClient\Abstracts\BaseObject;

class User extends BaseObject
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
}
