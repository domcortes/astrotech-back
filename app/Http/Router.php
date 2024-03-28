<?php

namespace App\Http;

use App\Database\TodoMigration;
use App\Http\Controllers\TodoApiController;

class Router
{
    private TodoApiController $api;
    private TodoMigration $migration;

    public function __construct(TodoApiController $api, TodoMigration $migration)
    {
        $this->api = $api;
        $this->migration = $migration;
    }

    public function route(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            return;
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $id = (int)$_GET['id'];
                    if ($id <= 0) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Invalid ID']);
                        return;
                    }
                    echo $this->api->getTodoById($id);
                } else {
                    $this->migration->migrate();
                    echo $this->api->getAllTodos();
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (!$data || !isset($data['task_name']) || empty($data['task_name'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid or missing task name']);
                    return;
                }
                
                echo $this->api->createTodo($data);
                break;
            case 'PUT':
                parse_str(file_get_contents("php://input"), $_PUT);
                $id = (int)$_GET['id'];
                if ($id <= 0) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid ID']);
                    return;
                }
                $json_data = key($_PUT);
                $json_data = str_replace('_', '', $json_data);
                echo $this->api->updateTodo($id, json_decode($json_data));
                break;
            case 'DELETE':
                $id = (int)$_GET['id'];
                if ($id <= 0) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid ID']);
                    return;
                }

                echo $this->api->deleteTodo($id);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed']);
        }
    }
}
