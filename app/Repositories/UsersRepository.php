<?php

namespace App\Repositories;

use App\Models\Collections\UsersCollection;

interface UsersRepository
{
    public function getAll(): UsersCollection;
}