<?php

namespace App\Services;

use App\Models\User;
use DateTime;
use Illuminate\Support\Str;

class AuthenticationService
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createToken(): string
    {
        $token = Str::random(20);
        $user = $this->user;

        $user->update([
            'authentication_token' => $token,
            'authentication_token_generated_at' => date('Y-m-d h:i:s')
        ]);

        return $token;
    }

    public function checkToken(string $token): bool
    {
        return $this->user->authentication_token == $token
            && ! $this->tokenHasExpired();
    }

    public function tokenHasExpired(): bool
    {
        return $this->user->authentication_token_generated_at
            ->isBefore(now()->subDay());
    }
}
