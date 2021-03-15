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
    public function list(array $query = []) : Collection
    {
        return new Collection($this->api, 'bank/account', $query);
    }
}
