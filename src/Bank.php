<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class Bank extends ApiObject
{
    /**
     * Find account.
     * @param $uuid
     * @return self
     */
    public function find(string $uuid) : self
    {
        $request = $this->api->request('bank/'.$uuid);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * List accounts.
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list() : Collection
    {
        return new Collection($this->api, 'bank', 100, 0, get_class($this));
    }

    /**
     * Create bank.
     * @param string $type
     * @return self
     */
    public function create(string $type) : self
    {
        $request = $this->api->request('bank', 'POST', ['type' => $type]);
        $this->fill($request->getResponse()->data);
        
        return $this;
    }
}
