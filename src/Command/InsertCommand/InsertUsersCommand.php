<?php


namespace App\Command\InsertCommand;

use App\Command\InsertCommand\InsertCommands;

class InsertUsersCommand extends InsertCommands{

    public function insert($name, $password){
        $sql = 'INSERT INTO users.Users (name, hshpassword) VALUES  (:name, :password)';
        $execute = [
            'name' => $name,
            'password' => $password
        ];

        return $this->inserts($sql, $execute);
    }


}