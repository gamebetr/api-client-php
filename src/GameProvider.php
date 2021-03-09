<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class GameProvider extends ApiObject
{
    /**
     * Find game provider.
     * @param $uuid
     * @return self
     */
    public function find(string $uuid) : self
    {
        $request = $this->api->request('game-center/provider/'.$uuid);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * List providers.
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list(array $query = []) : Collection
    {
        return new Collection($this->api, 'gamecenter/provider', $query);
    }
}
