<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class Game extends ApiObject
{
    /**
     * Find game
     * @param string $uuid
     * @return self
     */
    public function find(string $uuid) : self
    {
        $request = $this->api->request('gamecenter/game/' . $uuid);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * List games.
     * @param array $query
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list(array $query = []) : Collection
    {
        return new Collection($this->api, 'gamecenter/game', $query);
    }

    /**
     * Launch game.
     * @param string $uuid
     * @param array $query
     * @return string
     */
    public function launch(string $uuid, array $query = [])
    {
        $request = $this->api->request('gamecenter/game/' . $uuid . '/launch?' . http_build_query($query));

        return $request->getResponse()->data;
    }
}
