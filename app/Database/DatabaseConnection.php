<?php

namespace App\Database;

use Dotenv\Dotenv;
use mysqli;

class DatabaseConnection
{
    private string $db_host;
    private string $db_user;
    private string $db_password;
    private string $db_db;
    private mysqli $mysqli;

    const DEEP_LEVEL_DIR = 2;
    const DIR = __DIR__;

    public function __construct()
    {
        $dirName = dirname(self::DIR, self::DEEP_LEVEL_DIR);

        $dotenv = Dotenv::createImmutable($dirName);
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

    private function connect(): void
    {
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

    public function getConnection(): mysqli
    {
        return $this->mysqli;
    }

    public function closeConnection(): void
    {
        $this->mysqli->close();
    }
}
