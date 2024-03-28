<?php

namespace App\Database;

class ToDoMigration
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function migrate(): void
    {
        $query = "CREATE TABLE IF NOT EXISTS to_do (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    task_name VARCHAR(255) NOT NULL,
                    done BOOLEAN NOT NULL DEFAULT false
                  )";

        $result = $this->connection->getConnection()->query($query);

        if (!$result) {
            die('Error creating table: ' . $this->connection->getConnection()->error);
        }
    }
}
