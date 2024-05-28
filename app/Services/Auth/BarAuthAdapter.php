<?php

namespace App\Services\Auth;

use External\Bar\Auth\LoginService;

class BarAuthAdapter implements AuthAdapterInterface
{
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function authenticate(string $login, string $password): bool
    {
        return $this->loginService->login($login, $password);
    }

    public function getSystem(): string
    {
        return 'BAR';
    }
}
