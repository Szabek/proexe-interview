<?php

namespace App\Http\Controllers;

use App\Exceptions\NoAuthAdapterFoundException;
use App\Factories\AuthAdapterFactory;
use App\Http\Requests\LoginRequest;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $login = $validated['login'];
        $password = $validated['password'];

        try {
            $adapter = AuthAdapterFactory::create($login);
        } catch (NoAuthAdapterFoundException $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
            ], 400);
        }

        if ($adapter && $adapter->authenticate($login, $password)) {

            $system = $adapter->getSystem();

            $token = $this->generateJwtToken($login, $system);

            return response()->json([
                'status' => 'success',
                'token' => $token,
            ]);
        }

        return response()->json([
            'status' => 'failure',
        ], 400);
    }

    private function generateJwtToken(string $login, string $system): string
    {
        $payload = [
            'login' => $login,
            'context' => $system,
            'iat' => now()->timestamp,
            'exp' => now()->addMinutes(config('sanctum.expiration', 60))->timestamp,
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}
