<?php
require_once 'Database.php';

class TodoAPI {
    private $connection;

    public function __construct(DatabaseConnection $connection) {
        $this->connection = $connection;
    }

    public function getAllTodos() {
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

    public function getTodoById($id) {
        $query = "SELECT * FROM to_do WHERE id = $id";
        $result = $this->connection->getConnection()->query($query);

        if ($result->num_rows > 0) {
            return json_encode($result->fetch_assoc());
        } else {
            return json_encode(['error' => 'Todo not found']);
        }
    }

    public function createTodo($data) {
        $nombre = $data['nombre'];
        $hecha = $data['hecha'];

        $query = "INSERT INTO to_do (nombre, hecha) VALUES ('$nombre', $hecha)";
        $result = $this->connection->getConnection()->query($query);

        if ($result) {
            return json_encode(['message' => 'Todo created successfully']);
        } else {
            return json_encode(['error' => 'Failed to create todo']);
        }
    }

    public function updateTodo($id, $data) {
        $nombre = $data['nombre'];
        $hecha = $data['hecha'];

        $query = "UPDATE to_do SET nombre = '$nombre', hecha = $hecha WHERE id = $id";
        $result = $this->connection->getConnection()->query($query);

        if ($result) {
            return json_encode(['message' => 'Todo updated successfully']);
        } else {
            return json_encode(['error' => 'Failed to update todo']);
        }
    }

    public function deleteTodo($id) {
        $query = "DELETE FROM to_do WHERE id = $id";
        $result = $this->connection->getConnection()->query($query);

        if ($result) {
            return json_encode(['message' => 'Todo deleted successfully']);
        } else {
            return json_encode(['error' => 'Failed to delete todo']);
        }
    }
}