<?php
require_once 'ToDoApi.php';
require_once 'ToDoMigration.php';

class Router
{
    private $api;
    private $migration;

    public function __construct(TodoAPI $api, TodoMigration $migration)
    {
        $this->api = $api;
        $this->migration = $migration;
    }

    public function route()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            return;
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (isset ($_GET['id'])) {
                    echo $this->api->getTodoById($_GET['id']);
                } else {
                    $this->migration->migrate();
                    echo $this->api->getAllTodos();
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                echo $this->api->createTodo($data);
                break;
            case 'PUT':
                parse_str(file_get_contents("php://input"), $_PUT);
                $id = $_GET['id'];
                $json_data = key($_PUT);
                $json_data = str_replace('_', '', $json_data);
                echo $this->api->updateTodo($id, json_decode($json_data));
                break;
            case 'DELETE':
                parse_str(file_get_contents("php://input"), $_DELETE);
                $id = $_GET['id'];
                echo $this->api->deleteTodo($id);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed']);
        }
    }
}
?>