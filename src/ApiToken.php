<?php

namespace Gamebetr\ApiClient;

use Exception;
use Gamebetr\ApiClient\Abstracts\ApiObject;

class ApiToken extends ApiObject
{
    /**
     * Login method.
     * @param string $email
     * @param string $password
     * @return self
     */
    public function login(string $email, string $password) : self
    {
        $request = $this->api->request(
            'user/login',
            'POST',
            ['email' => $email, 'password' => $password],
            false
        );
        $this->fill($request->getResponse()->data);
        $this->api->apiToken = $this->token;

        return $this;
    }

    /**
     * Refresh.
     * @param string $refreshToken
     * @return self
     */
    public function refresh(string $refreshToken = null) : self
    {
        if (! $refreshToken) {
            $refreshToken = $this->refresh_token;
        }
        if (! $refreshToken) {
            throw new Exception('Unknown refresh token', 500);
        }
        $request = $this->api->request(
            'user/refresh',
            'POST',
            ['refresh_token' => $refreshToken],
            false
        );
        $this->fill($request->getResponse()->data);
        $this->api->apiToken = $this->token;

        return $this;
    }
}
