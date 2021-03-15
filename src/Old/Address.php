<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class Address extends ApiObject
{
    /**
     * Find address.
     * @param $address
     * @return self
     */
    public function find(string $address) : self
    {
        $request = $this->api->request('paybetr/address/'.$address);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * List addresses.
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list(array $query = []) : Collection
    {
        return new Collection($this->api, 'paybetr/address', $query);
    }

    /**
     * Create address.
     * @param string $symbol
     * @return self
     */
    public function create(string $symbol) : self
    {
        $request = $this->api->request('paybetr/address', 'POST', ['symbol' => $symbol]);
        $this->fill($request->getResponse()->data);

        return $this;
    }
}
