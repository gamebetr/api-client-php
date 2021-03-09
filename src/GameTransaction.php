<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class GameTransaction extends ApiObject
{
    /**
     * Find game transaction.
     * @param $uuid
     * @return self
     */
    public function find(string $uuid) : self
    {
        $request = $this->api->request('game-center/transaction/'.$uuid);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * List transactions.
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list(array $query = []) : Collection
    {
        return new Collection($this->api, 'gamecenter/transaction', $query);
    }
}