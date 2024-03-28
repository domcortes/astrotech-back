<?php

namespace App\Models;

use App\Database\DatabaseConnection;

class ToDo
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM to_do";
        $result = $this->connection->getConnection()->query($query);

        $todos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $todos[] = $row;
            }
        }

        return $todos;
    }

    public function getById($id): ?array
    {
        try {
            $query = "SELECT * FROM to_do WHERE id = $id";
            $result = $this->connection->getConnection()->query($query);

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return ['error' => 'Todo not found'];
            }
        } catch (\Throwable $th) {
            echo "Get by id error" . $th->getMessage();
            return null;
        }
    }

    public function create(array $data): bool
    {
        try {
            $nombre = $data['task_name'];

            $query = "INSERT INTO to_do (task_name, done) VALUES ('$nombre', 0)";
            $result = $this->connection->getConnection()->query($query);

            return $result;
        } catch (\Throwable $th) {
            echo "Error creating " . $th->getMessage();
            return false;
        }
    }

    public function update(int $id, object $data): bool
    {
        try {
            $hecha = $data->done ? 1 : 0;

            $query = "UPDATE to_do SET done = $hecha WHERE id = $id";
            $result = $this->connection->getConnection()->query($query);

            return $result;
        } catch (\Throwable $th) {
            echo "Error updating: " . $th->getMessage();
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM to_do WHERE id = $id";
            $result = $this->connection->getConnection()->query($query);

            return $result;
        } catch (\Throwable $th) {
            echo 'Error deleting ' . $th->getMessage();
            return false;
        }
    }
}
?>
