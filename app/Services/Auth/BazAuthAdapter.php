<?php

namespace App\Services\Auth;

use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;

class BazAuthAdapter implements AuthAdapterInterface
{
    protected Authenticator $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function authenticate(string $login, string $password): bool
    {
        $response = $this->authenticator->auth($login, $password);
        return $response instanceof Success;
    }
}
