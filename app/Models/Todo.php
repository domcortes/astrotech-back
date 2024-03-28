<?php
namespace App\Models;

use App\Database\DatabaseConnection;

class ToDo
{
    private $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAll()
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

    public function getById($id)
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
        }
    }

    public function create($data)
    {
        try {
            $nombre = $data['task_name'];

            $query = "INSERT INTO to_do (task_name, done) VALUES ('$nombre', 0)";
            $result = $this->connection->getConnection()->query($query);

            return $result;
        } catch (\Throwable $th) {
            echo "Error creating " . $th->getMessage();
        }
    }

    public function update($id, $data)
    {
        try {
            $hecha = $data->done ? 1 : 0;
    
            $query = "UPDATE to_do SET done = $hecha WHERE id = $id";
            $result = $this->connection->getConnection()->query($query);
    
            return $result;
        } catch (\Throwable $th) {
            echo "Error updating: " . $th->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM to_do WHERE id = $id";
            $result = $this->connection->getConnection()->query($query);

            return $result;
        } catch (\Throwable $th) {
            echo 'Error deleting ' . $th->getMessage();
        }
    }
}
?>
