<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\AuthRequest;
use App\Services\AuthService;

class AuthController extends AbstractController
{
    public function login(AuthRequest $request, AuthService $authService)
    {
        $validated = $request->validated();
        $token     = $authService->login($validated);
        return $this->success(['token' => $token]);
    }
}
