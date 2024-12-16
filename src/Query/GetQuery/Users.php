<?php


namespace App\Query\GetQuery;

use App\Query\GetQuery\Query;


class Users extends Query
{

    public function getUsersById($id){
        $sql = 'SELECT * FROM users.Users WHERE id = :id';
        $execute = ['id' => $id];
        return $this->fetch($sql, $execute, 'Пользовател не найден');
    }


}