<?php

namespace App\Command\UpdateCommand;

use App\Model\DatabaseConfig\DatabaseConnect;

class UpdateTokenCommand
{

    public function update($name, $jwt_refresh){
        $db = new DatabaseConnect();
        $pdo = $db->getConnection();
        $sql = 'UPDATE users.refresh_tokens SET refresh_token = :refresh_token WHERE username = :name;';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'refresh_token' => $jwt_refresh,
        ]);
        return true;
    }

}