<?php
class DatabaseConnection {
    private $db_host;
    private $db_user;
    private $db_password;
    private $db_db;
    private $mysqli;

    public function __construct() {
        $this->db_host = 'localhost';
        $this->db_user = 'root';
        $this->db_password = 'martin07081988';
        $this->db_db = 'desafio';
        $this->connect();
    }

    private function connect() {
        $this->mysqli = new mysqli(
            $this->db_host,
            $this->db_user,
            $this->db_password,
            $this->db_db
        );

        if ($this->mysqli->connect_error) {
            die('Errno: ' . $this->mysqli->connect_errno . '<br>' . 'Error: ' . $this->mysqli->connect_error);
        }
    }

    public function getConnection() {
        return $this->mysqli;
    }

    public function closeConnection() {
        $this->mysqli->close();
    }

    
}
