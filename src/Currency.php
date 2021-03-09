<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class Currency extends ApiObject
{
    /**
     * Find currency.
     * @param $symbol
     * @return self
     */
    public function find(string $symbol) : self
    {
        $request = $this->api->request('paybetr/currency/'.$symbol);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * List currencies.
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list(array $query = []) : Collection
    {
        return new Collection($this->api, 'paybetr/currency', $query);
    }

    /**
     * Convert currency.
     * @param string $fromSymbol
     * @param string $toSymbol
     * @param float $amount
     */
    public function convert(string $fromSymbol, string $toSymbol, float $amount = 1)
    {
        return $this->api->request('paybetr/currency/'.$fromSymbol.'/convert/'.$toSymbol.'/'.$amount)->getResponse();
    }
}
