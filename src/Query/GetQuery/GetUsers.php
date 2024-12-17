<?php

declare(strict_types=1);

namespace App\Query\GetQuery;


use App\Query\GetQuery\Query;

class GetUsers extends Query
{

    public function getAllColumnsUsersByName($name){
        $sql = 'SELECT * FROM users.Users WHERE name = :name';
        $execute = ['name' => $name];
        return $this->fetch($sql, $execute, 'Пользовател не найден');
    }

    public function getUsersByName(string $name): array {
        $sql = 'SELECT id, name, roles FROM users.Users WHERE name = :name';
        $execute = ['name' => $name];
        return $this->fetch($sql, $execute, 'Пользовател не найден');
    }

    public function getUsersInRef(string $name): array {
        $sql = 'SELECT username FROM users.refresh_tokens WHERE username = :name';
        $execute = ['name' => $name];
        return $this->fetch($sql, $execute, 'Пользовател не найден');
    }


}