<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interface\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{

    public function __construct(protected User $user)
    {
    }
    public function all()
    {
        return $this->user->all();
    }

    public function findById(int $id): ?User
    {
        return $this->user->query()->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->user->query()->where('email', $email)->first();
    }

    public function register(array $data): User
    {
        return $this->user->query()->create($data);
    }

    public function verify(User $user)
    {

        $user->markEmailAsVerifiedWithCode();
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function login(User $user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logout(User $user): bool
    {
        return $user->currentAccessToken()->delete();
    }

    public function resendPassword(User $user)
    {
        return $user->generateEmailVerificationCode();
    }

    public function forgotPassword(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function resetPassword(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function changePassword(User $user, array $data): bool
    {
        return $user->update($data);
    }
    public function checkEmail(string $email): bool
    {
        return $this->user->query()->where('email', $email)->exists();
    }

}
