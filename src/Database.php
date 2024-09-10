<?php
namespace App;

use PDO;



class Database {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}