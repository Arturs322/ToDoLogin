<?php

namespace App\Controllers;

use App\Models\Collections\UsersCollection;
use App\Models\User;
use App\Repositories\MysqlUsersRepository;
use App\Repositories\UsersRepository;

class UsersController
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MysqlUsersRepository();
    }

    public function index()
    {
        $users = $this->usersRepository->getAll();
        require_once "app/Views/users.template.php";
    }
}