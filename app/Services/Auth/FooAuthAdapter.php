<?php

namespace App\Services\Auth;

use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;

class FooAuthAdapter implements AuthAdapterInterface
{
    protected AuthWS $authWS;

    public function __construct(AuthWS $authWS)
    {
        $this->authWS = $authWS;
    }

    public function authenticate(string $login, string $password): bool
    {
        try {
            $this->authWS->authenticate($login, $password);
            return true;
        } catch (AuthenticationFailedException $e) {
            return false;
        }
    }

    public function getSystem(): string
    {
        return 'FOO';
    }
}
