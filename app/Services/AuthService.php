<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function login(array $credentials)
    {
        $user = $this->userRepository->findUserEmail($credentials['email']);

        if ($user && Hash::check($credentials['password'], $user->password)) {
           
            return $user;
        }

        return null;
    }

    public function logout(User $user)
    {
        $this->userRepository->logout($user);

    }
}