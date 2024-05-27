<?php

namespace App\Services\Auth;

interface AuthAdapterInterface
{
    public function authenticate(string $login, string $password): bool;
}
