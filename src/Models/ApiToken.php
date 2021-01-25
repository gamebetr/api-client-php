<?php

namespace Gamebetr\ApiClient\Models;

use stdClass;

class ApiToken
{
    /**
     * Id.
     * @var string
     */
    public $id;

    /**
     * Name.
     * @var string
     */
    public $name;

    /**
     * Token.
     * @var string
     */
    public $token;

    /**
     * Token expiration.
     * @var string
     */
    public $tokenExpiration;

    /**
     * Refresh token.
     * @var string
     */
    public $refreshToken;

    /**
     * Refresh token expiration.
     * @var string
     */
    public $refreshTokenExpiration;

    /**
     * Class constructor.
     * @param \stdClass $user
     * @return void
     */
    public function __construct(stdClass $token = null)
    {
        if (! $token) {
            return;
        }
        if (isset($token->id)) {
            $this->id = $token->id;
        }
        if (! isset($token->attributes)) {
            return;
        }
        if (isset($token->attributes->name)) {
            $this->name = $token->attributes->name;
        }
        if (isset($token->attributes->token)) {
            $this->token = $token->attributes->token;
        }
        if (isset($token->attributes->token_expires_at)) {
            $this->tokenExpiration = $token->attributes->token_expires_at;
        }
        if (isset($token->attributes->refresh_token)) {
            $this->refreshToken = $token->attributes->refresh_token;
        }
        if (isset($token->attributes->refresh_token_expires_at)) {
            $this->refreshTokenExpiration = $token->attributes->refresh_token_expires_at;
        }
    }
}
