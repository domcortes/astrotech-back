<?php
require_once __DIR__ . '/vendor/autoload.php';

class DatabaseConnection
{
    private $db_host;
    private $db_user;
    private $db_password;
    private $db_db;
    private $mysqli;

    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $databaseHost = $_ENV['DATABASE_HOST'];
        $databaseUser = $_ENV['DATABASE_USER'];
        $databasePassword = $_ENV['DATABASE_PASSWORD'];
        $databaseDb = $_ENV['DATABASE_NAME'];

        $this->db_host = $databaseHost;
        $this->db_user = $databaseUser;
        $this->db_password = $databasePassword;
        $this->db_db = $databaseDb;
        $this->connect();
    }

    private function connect()
    {
        $this->mysqli = new mysqli(
            $this->db_host,
            $this->db_user,
            $this->db_password,
            $this->db_db
        );

        if ($this->mysqli->connect_error) {
            die ('Errno: ' . $this->mysqli->connect_errno . '<br>' . 'Error: ' . $this->mysqli->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->mysqli;
    }

    public function closeConnection()
    {
        $this->mysqli->close();
    }


}
