<?php

namespace App\Factories;

use App\Exceptions\NoAuthAdapterFoundException;
use App\Services\Auth\AuthAdapterInterface;
use App\Services\Auth\BarAuthAdapter;
use App\Services\Auth\BazAuthAdapter;
use App\Services\Auth\FooAuthAdapter;
use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Foo\Auth\AuthWS;

class AuthAdapterFactory
{
    /**
     * @throws NoAuthAdapterFoundException
     */
    public static function create(string $login): ?AuthAdapterInterface
    {
        return match (true) {
            str_starts_with($login, 'FOO_') => new FooAuthAdapter(new AuthWS()),
            str_starts_with($login, 'BAR_') => new BarAuthAdapter(new LoginService()),
            str_starts_with($login, 'BAZ_') => new BazAuthAdapter(new Authenticator()),
            default => throw new NoAuthAdapterFoundException(),
        };
    }
}
