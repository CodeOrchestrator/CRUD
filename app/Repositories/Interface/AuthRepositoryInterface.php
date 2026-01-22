<?php

namespace App\Repositories\Interface;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function all();
    public function findById(int $id): ?User;
    public function findByEmail(string $email ): ?User;
    public function register(array $data): User;
    public function verify(User $user);
    public function login(User $user);
    public function logout(User $user):bool;
    public function resendPassword(User $user);
    public function forgotPassword(User $user, array $data): bool;
    public function resetPassword(User $user, array $data): bool;
    public function changePassword(User $user, array $data): bool;
    public function checkEmail(string $email): bool;

}
