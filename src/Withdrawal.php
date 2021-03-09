<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class Withdrawal extends ApiObject
{
    /**
     * Find withdrawal.
     * @param string $uuid
     * @return self
     */
    public function find(string $uuid) : self
    {
        $request = $this->api->request('paybetr/withdrawal/'.$uuid);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * List withdrawals.
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list(array $query = []) : Collection
    {
        return new Collection($this->api, 'paybetr/withdrawal', $query);
    }

    /**
     * Create withdrawal.
     * @param string $symbol
     * @param string $destination
     * @param float $amount
     * @return self
     */
    public function create(string $symbol, string $destination, float $amount) : self
    {
        $request = $this->api->request('paybetr/withdrawal', 'POST', ['symbol' => $symbol, 'destination' => $destination, 'amount' => $amount]);
        $this->fill($request->getResponse()->data);

        return $this;
    }
}
