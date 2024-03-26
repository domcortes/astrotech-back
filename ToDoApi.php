<?php
require_once 'Database.php';

class TodoAPI
{
    private $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAllTodos()
    {
        $query = "SELECT * FROM to_do";
        $result = $this->connection->getConnection()->query($query);

        $todos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $todos[] = $row;
            }
        }

        return json_encode($todos);
    }

    public function getTodoById($id)
    {
        try {
            $query = "SELECT * FROM to_do WHERE id = $id";
            $result = $this->connection->getConnection()->query($query);

            if ($result->num_rows > 0) {
                return json_encode($result->fetch_assoc());
            } else {
                return json_encode(['error' => 'Todo not found']);
            }
        } catch (ErrorException $th) {
            echo "Get by id error" . $th->getMessage();
        }
    }

    public function createTodo($data)
    {
        try {
            $nombre = $data['task_name'];

            $query = "INSERT INTO to_do (task_name, done) VALUES ('$nombre', 0)";

            var_dump($query);
            $result = $this->connection->getConnection()->query($query);

            if ($result) {
                return json_encode(['message' => 'Todo created successfully']);
            } else {
                return json_encode(['error' => 'Failed to create todo']);
            }
        } catch (ErrorException $th) {
            echo "Error creating " . $th->getMessage();
        }
    }

    public function updateTodo($id, $data)
    {
        try {
            var_dump($data);
            $hecha = $data->done ? 1 : 0;
    
            $query = "UPDATE to_do SET done = $hecha WHERE id = $id";
            $result = $this->connection->getConnection()->query($query);
    
            if ($result) {
                return json_encode(['message' => 'Todo updated successfully']);
            } else {
                return json_encode(['error' => 'Failed to update todo']);
            }
        } catch (\Throwable $th) {
            echo "Error updating: " . $th->getMessage();
        }
    }

    public function deleteTodo($id)
    {
        try {
            $query = "DELETE FROM to_do WHERE id = $id";
            $result = $this->connection->getConnection()->query($query);

            if ($result) {
                return json_encode(['message' => 'Todo deleted successfully']);
            } else {
                return json_encode(['error' => 'Failed to delete todo']);
            }
        } catch (\Throwable $th) {
            echo 'Error deleting ' . $th->getMessage();
        }
    }
}