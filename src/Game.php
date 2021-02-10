<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class Game extends ApiObject
{
    /**
     * Find game
     * @param $uuid
     * @return self
     */
    public function find(string $uuid) : self
    {
        $request = $this->api->request('game-center/game/'.$uuid);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * List providers.
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list() : Collection
    {
        return new Collection($this->api, 'game-center/game', 100, 0, get_class($this));
    }

    /**
     * Launch game.
     * @param array $parameters
     * @return string
     */
    public function launch(array $parameters = [])
    {
        $request = $this->api->request('game-center/launch', 'POST', $parameters);

        return $request->getResponse()->data;
    }
}
