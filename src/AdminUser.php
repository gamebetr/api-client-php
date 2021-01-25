<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class AdminUser extends ApiObject
{
    /**
     * List users.
     */
    public function listUsers()
    {
        return new Collection($this->api, 'admin/user', 100, 0, User::class);
    }
}
