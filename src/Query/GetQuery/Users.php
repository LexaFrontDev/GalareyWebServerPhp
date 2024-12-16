<?php


namespace App\Query\GetQuery;

use App\Query\GetQuery\FetchAssocQuery;


class Users
{

    private $fetchAssoc;

    public function __construct(FetchAssocQuery $fetchAssoc)
    {
        $this->fetchAssoc = $fetchAssoc;
    }

    public function getUsersById($id){
        $sql = 'SELECT * FROM users.Users WHERE id = :id';
        $execute = ['id' => $id];
        return $this->fetchAssoc->fetch($sql, $execute, 'Пользовател не найден');
    }


}