<?php

include_once(__DIR__."/../config/config.php");


class Database {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    public function __construct($charset = 'utf8') {

        $this->host = DB_CONFIG["default"]["DB_HOST"] ;
        $this->db = DB_CONFIG["default"]["DB_NAME"];
        $this->user = DB_CONFIG["default"]["DB_USER"];
        $this->pass = DB_CONFIG["default"]["DB_PASS"];
        $this->charset = $charset;

        $this->connect();
    }

    private function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }

    function SelectSql($sql, $params = [], $fetchOne = true) {
        $mix = [];
        $query = $this->pdo->prepare($sql);
        $data = $query->execute($params);

        if ( $data and ($query->rowCount() == 1 and $fetchOne)) { 
            $mix = $query->fetch(PDO::FETCH_ASSOC);
        } else if ( $data and $query->rowCount() >= 1) {
            $mix = $query->fetchAll(PDO::FETCH_ASSOC);
        } 
        return $mix;
    }
}
?>