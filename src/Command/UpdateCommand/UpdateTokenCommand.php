<?php

namespace App\Command\UpdateCommand;

use App\Model\DatabaseConfig\DatabaseConnect;

class UpdateTokenCommand
{
    private $db;
    public function __construct(DatabaseConnect $db)
    {
        $this->db = $db;
    }

    public function update($name, $jwt_refresh){
        $pdo = $this->db->getConnection();
        $sql = 'UPDATE users.refresh_tokens SET refresh_token = :refresh_token WHERE username = :name;';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'refresh_token' => $jwt_refresh,
        ]);
        return true;
    }

}