<?php

declare(strict_types=1);

namespace App\Command\InsertCommand;


use App\Model\DatabaseConfig\DatabaseConnect;

abstract class InsertCommands
{
    private $db;

    public function __construct(DatabaseConnect $db)
    {
        $this->db = $db;
    }

    public function inserts(string $sql, array $execute){
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($execute);
        return true;
    }

}