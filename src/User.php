<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Abstracts\ApiObject;

class User extends ApiObject
{
    /**
     * Me.
     * @return self
     */
    public function me() : self
    {
        $request = $this->api->request('user');
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * Login.
     * @param string $email
     * @param string $password
     * @return \Gamebetr\ApiClient\ApiToken
     */
    public function login(string $email, string $password)
    {
        $request = $this->api->request('user/login', 'POST', ['email' => $email, 'password' => $password], false);

        return new ApiToken($this->api, $request->getResponse()->data);
    }

    /**
     * Register.
     * @param string $name
     * @param string $email
     * @param string $password
     * @return self
     */
    public function register(string $name, string $email, string $password) : self
    {
        $request = $this->api->request('user', 'POST', ['name' => $name, 'email' => $email, 'password' => $password], false);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * Update.
     * @param array $attributes
     * @return self
     */
    public function update(array $attributes = []) : self
    {
        $request = $this->api->request('user', 'PUT', $attributes);
        $this->fill($request->getResponse()->data);

        return $this;
    }

    /**
     * Enable 2fa.
     * @return \Gamebetr\ApiClient\TwoFactor
     */
    public function enable2fa() : TwoFactor
    {
        $request = $this->api->request('user/enable2fa');

        return new TwoFactor($this->api, $request->getResponse()->data);
    }

    /**
     * Disable 2fa.
     * @return void
     */
    public function disable2fa()
    {
        $this->api->request('user/disable2fa');
    }

    /**
     * List.
     * @return \Gamebetr\ApiClient\Collection
     */
    public function list()
    {
        return new Collection($this->api, 'user/list', 100, 0, get_class($this));
    }
}
