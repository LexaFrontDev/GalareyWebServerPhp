<?php


namespace App\Command\InsertCommand;

use App\Model\DatabaseConfig\DatabaseConnect;

class InsertRefToken
{

    public function insertRefToken($jwt_refresh, $name){
        $db = new DatabaseConnect();
        $pdo = $db->getConnection();
        $sql = 'INSERT INTO users.refresh_tokens (username, refresh_token) VALUES  (:refresh_token, :username)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'refresh_token' => $jwt_refresh,
            'username' => $name
        ]);
        return true;
    }

}