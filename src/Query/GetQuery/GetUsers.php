<?php


namespace App\Query\GetQuery;


use App\Query\GetQuery\FetchAssocQuery;

class GetUsers
{
    private $fetchAssoc;

    public function __construct(FetchAssocQuery $fetchAssoc)
    {
        $this->fetchAssoc = $fetchAssoc;
    }

    public function getUsers($name){
        $sql = 'SELECT * FROM users.Users WHERE name = :name';
        $execute = ['name' => $name];
        return $this->fetchAssoc->fetch($sql, $execute, 'Пользовател не найден');
    }

    public function getUsersInRef($name){
        $sql = 'SELECT * FROM users.refresh_tokens WHERE username = :name';
        $execute = ['name' => $name];
        return $this->fetchAssoc->fetch($sql, $execute, 'Пользовател не найден');
    }

}