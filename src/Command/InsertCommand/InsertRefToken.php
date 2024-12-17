<?php


namespace App\Command\InsertCommand;


use App\Command\InsertCommand\InsertCommands;

class InsertRefToken extends InsertCommands
{

    public function insertRefToken($jwt_refresh, $name){
        $sql = 'INSERT INTO users.refresh_tokens (username, refresh_token) VALUES  (:refresh_token, :username)';
        $execute = [
            'refresh_token' => $jwt_refresh,
            'username' => $name
        ];
        $this->inserts($sql, $execute);
    }

}