<?php


namespace App\Command\InsertCommand;

use App\Model\DatabaseConfig\DatabaseConnect;


class InsertUsersCommand
{

    public function create($name, $password)
    {
        $db = new DatabaseConnect();
        $pdo = $db->getConnection();
        $sql = 'INSERT INTO users.Users (name, hshpassword) VALUES  (:name, :password)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'password' => $password
        ]);

        return true;
    }


}