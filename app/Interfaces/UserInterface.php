<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface UserInterface
{

    public function getCurrentUser(): ?User;
    public function getUserById(int $id): ?User;
}
