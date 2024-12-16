<?php


namespace App\Query\GetQuery;


use App\Model\DatabaseConfig\DatabaseConnect;

abstract class Query
{

    public function fetch(string $sql, array $execute, string $notFind){
        $db = new DatabaseConnect();
        $pdo = $db->getConnection();
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
        $db = new DatabaseConnect();
        $pdo = $db->getConnection();
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