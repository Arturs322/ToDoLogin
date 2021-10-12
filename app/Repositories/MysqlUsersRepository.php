<?php

namespace App\Repositories;

use App\Models\Collections\UsersCollection;
use App\Models\User;
use PDO;
use PDOException;

class MysqlUsersRepository implements UsersRepository
{
    private PDO $connection;

    public function __construct()
    {
        $host = '127.0.0.1';
        $db = 'Todo-Login';
        $user = 'root';
        $pass = '';
        $dsn = "mysql:host = $host;dbname=$db;charset=UTF8";
        try {
            $this->connection = new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getAll(): UsersCollection
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([]);

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $collection = new UsersCollection();

        foreach ($users as $user) {
            $collection->add(new User(
                $user['id'],
                $user['name'],
            ));
        }
        return $collection;
    }
}