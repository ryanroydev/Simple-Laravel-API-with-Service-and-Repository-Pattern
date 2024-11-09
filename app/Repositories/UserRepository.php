<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data) : User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function findUserEmail(string $email) : User|null
    {
        return User::where('email', $email)->first();
    }

    public function logout(User $user)
    {
        $user->tokens->each(function($token){   
            $token->delete();
        });
    }
}