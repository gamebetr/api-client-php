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
    public function list(array $query = []) : Collection
    {
        return new Collection($this->api, 'bank/transaction', $query);
    }

    /**
     * Create transaction.
     * @return self
     */
    public function create(string $accountUuid, float $amount, array $tags = []) : self
    {
        $request = $this->api->request('bank/transaction', 'POST', [
            'account_uuid' => $accountUuid,
            'amount' => $amount,
            'tags' => $tags,
        ]);
        $this->fill($request->getResponse()->data);

        return $this;
    }
}
