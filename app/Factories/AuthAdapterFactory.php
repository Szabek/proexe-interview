<?php

namespace App\Factories;

use App\Services\Auth\AuthAdapterInterface;
use App\Services\Auth\BarAuthAdapter;
use App\Services\Auth\BazAuthAdapter;
use App\Services\Auth\FooAuthAdapter;
use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Foo\Auth\AuthWS;

class AuthAdapterFactory
{
    public static function create(string $login): ?AuthAdapterInterface
    {
        if (str_starts_with($login, 'FOO_')) {
            return new FooAuthAdapter(new AuthWS());
        } elseif (str_starts_with($login, 'BAR_')) {
            return new BarAuthAdapter(new LoginService());
        } elseif (str_starts_with($login, 'BAZ_')) {
            return new BazAuthAdapter(new Authenticator());
        }
        return null;
    }
}
