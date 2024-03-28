<?php
namespace App\Database;
use Dotenv\Dotenv;

class DatabaseConnection
{
    private $db_host;
    private $db_user;
    private $db_password;
    private $db_db;
    private $mysqli;

    const DEEP_LEVEL_DIR = 2;
    const DIR = __DIR__;

    public function __construct()
    {
        $dirName = dirname(self::DIR,self::DEEP_LEVEL_DIR);

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

    private function connect()
    {
        $this->mysqli = new \mysqli(
            $this->db_host,
            $this->db_user,
            $this->db_password,
            $this->db_db
        );

        if ($this->mysqli->connect_error) {
            die('Errno: ' . $this->mysqli->connect_errno . '<br>' . 'Error: ' . $this->mysqli->connect_error);
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
