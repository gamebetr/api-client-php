<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class Account extends ApiObject
{
    /**
     * Find account.
     * @param $uuid
     * @return self
     */
    public function find(string $uuid) : self
    {
        $request = $this->api->request('bank/account/'.$uuid);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * List accounts.
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list() : Collection
    {
        return new Collection($this->api, 'bank/account', 100, 0, get_class($this));
    }
}
