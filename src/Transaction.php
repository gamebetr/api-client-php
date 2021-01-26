<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class Transaction extends ApiObject
{
    /**
     * Find transaction.
     * @param $uuid
     * @return self
     */
    public function find(string $uuid) : self
    {
        $request = $this->api->request('bank/transaction/'.$uuid);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * List transactions.
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list() : Collection
    {
        return new Collection($this->api, 'bank/transaction', 100, 0, get_class($this));
    }
}