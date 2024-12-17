<?php


namespace App\Query\GetQuery;


use App\Model\DatabaseConfig\DatabaseConnect;

abstract class Query
{

    private $db;

    public function __construct(DatabaseConnect $db)
    {
        $this->db = $db;
    }

    public function fetch(string $sql, array $execute, string $notFind){
        $pdo = $this->db->getConnection();
        $sql = $sql;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($execute);
        $fetch = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$fetch) {
            throw new \Exception( "$notFind");
        }

        return $fetch;
    }

    public function fetchCheck(string $sql, array $execute, string $notFind){
        $pdo = $this->db->getConnection();
        $sql = $sql;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($execute);
        $fetch = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($fetch) {
            throw new \Exception( "$notFind");
        }

        return true;
    }

}