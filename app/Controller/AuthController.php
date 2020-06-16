<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\AuthRequest;
use App\Services\AuthService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class AuthController
{
    public function login(AuthRequest $request, ResponseInterface $response, AuthService $authService)
    {
        $validated = $request->validated();
        $token = $authService->login($validated);
        return $response->json(['token' => $token]);
    }
}
