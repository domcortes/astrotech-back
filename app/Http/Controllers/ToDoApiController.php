<?php

namespace App\Http\Controllers;

use App\Models\ToDo;

class TodoApiController
{
    private ToDo $toDoModel;

    public function __construct(ToDo $toDoModel)
    {
        $this->toDoModel = $toDoModel;
    }

    public function getAllTodos(): string
    {
        $todos = $this->toDoModel->getAll();
        return json_encode($todos);
    }

    public function getTodoById(int $id): string
    {
        $todo = $this->toDoModel->getById($id);
        return json_encode($todo);
    }

    public function createTodo(array $data): string
    {
        $result = $this->toDoModel->create($data);
        if ($result) {
            return json_encode(['message' => 'Todo created successfully']);
        } else {
            return json_encode(['error' => 'Failed to create todo']);
        }
    }

    public function updateTodo(int $id, object $data): string
    {
        $result = $this->toDoModel->update($id, $data);
        if ($result) {
            return json_encode(['message' => 'Todo updated successfully']);
        } else {
            return json_encode(['error' => 'Failed to update todo']);
        }
    }

    public function deleteTodo(int $id): string
    {
        $result = $this->toDoModel->delete($id);
        if ($result) {
            return json_encode(['message' => 'Todo deleted successfully']);
        } else {
            return json_encode(['error' => 'Failed to delete todo']);
        }
    }
}
