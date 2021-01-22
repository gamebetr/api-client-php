<?php

namespace Gamebetr\ApiClient;

use Gamebetr\ApiClient\Contracts\RequestContract;

class Auth
{
    /**
     * Request.
     * @var \Gamebetr\ApiClient\Contracts\RequestContract
     */
    protected $request;

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
        return $this->request
                    ->requiresAuth(false)
                    ->method('POST')
                    ->parameters([
                        'email' => $email,
                        'password' => $password,
                    ])
                    ->request('user/login')
                    ->getResponse();
    }
}
