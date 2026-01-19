<?php

namespace App\Repositories\Interface;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function register($data): User;
}
