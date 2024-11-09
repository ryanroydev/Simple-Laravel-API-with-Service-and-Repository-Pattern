<?php
namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data) : User;
    public function findUserEmail(string $email) : User|null;
    public function logout(User $user);
}