<?php


namespace App\Query\GetQuery;


use App\Query\GetQuery\Query;

class GetUsers extends Query
{

    public function getUsers($name){
        $sql = 'SELECT * FROM users.Users WHERE name = :name';
        $execute = ['name' => $name];
        return $this->fetch($sql, $execute, 'Пользовател не найден');
    }

    public function getUsersInRef($name){
        $sql = 'SELECT * FROM users.refresh_tokens WHERE username = :name';
        $execute = ['name' => $name];
        return $this->fetch($sql, $execute, 'Пользовател не найден');
    }

}