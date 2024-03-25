<?php
require_once 'ToDoApi.php';

class Router {
    private $api;

    public function __construct(TodoAPI $api) {
        $this->api = $api;
    }

    public function route() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (isset($_GET['id'])) {
                    echo $this->api->getTodoById($_GET['id']);
                } else {
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
                $data = $_PUT;
                echo $this->api->updateTodo($id, $data);
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
