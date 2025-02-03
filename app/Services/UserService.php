<?php

namespace App\Services;

use App\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService implements UserInterface
{
    public function getCurrentUser(): ?User
    {
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        return $user;
    }

    public function getUserById(int $id): ?User
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }
        return $user;
    }
}
