<?php

namespace Gamebetr\ApiClient;

use Exception;
use Gamebetr\ApiClient\Contracts\RequestContract;
use Gamebetr\ApiClient\Models\ApiToken;

class Auth
{
    /**
     * Request.
     * @var \Gamebetr\ApiClient\Contracts\RequestContract
     */
    public $request;

    /**
     * Class constructor.
     * @param \Gamebetr\ApiClient\Contracts\RequestContract $request
     * @return void
     */
    public function __construct(RequestContract $request)
    {
        $this->request = $request;
    }

    /**
     * Static constructor.
     * @param \Gamebetr\ApiClient\Contracts\RequestContract $request
     * @return self
     */
    public static function init(RequestContract $request) : self
    {
        return new static($request);
    }

    /**
     * Login.
     * @param string $email
     * @param string $password
     * @return \Gamebetr\ApiClient\Objects\User
     */
    public function login(string $email, string $password)
    {
        if (! $response = $this->request
            ->requiresAuth(false)
            ->method('POST')
            ->parameters([
                'email' => $email,
                'password' => $password,
            ])
            ->request('user/login')
            ->getResponse()) {
            throw new Exception($this->response->getReason(), $this->response->getStatus());
        }

        return new ApiToken($response->data);
    }
}
