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
    public function list() : Collection
    {
        return new Collection($this->api, 'game-center/provider', 100, 0, get_class($this));
    }
}
