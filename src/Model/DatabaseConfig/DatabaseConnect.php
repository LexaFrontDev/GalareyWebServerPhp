<?php

namespace App\Model\DatabaseConfig;

class DatabaseConnect
{
    private $host = 'localhost';
    private $nameUser = 'postgres';
    private $dataBase = 'Galarey';
    private $password = '2008';
    private $conn;

    public function __construct()
    {
        try {
            $dsn = "pgsql:host=$this->host;port=5432;dbname=$this->dataBase";
            $this->conn = new \PDO($dsn, $this->nameUser, $this->password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Ошибка подключения: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function save($query)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
