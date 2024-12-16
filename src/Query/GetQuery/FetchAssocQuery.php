<?php

declare(strict_types = 1);

namespace App\Query\GetQuery;


use App\Model\DatabaseConfig\DatabaseConnect;

class FetchAssocQuery
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


}