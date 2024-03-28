<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Database\DatabaseConnection;
use App\Database\ToDoMigration;
use App\Http\Controllers\TodoApiController;
use App\Http\Router;
use App\Models\ToDo;
use App\Http\Headers;

class Main {
    public function main(){
        Headers::setHeaders();
    
        $databaseConnection = new DatabaseConnection();
        $mysqli = $databaseConnection->getConnection();
        
        if ($mysqli) {
            $toDoModel = new ToDo($databaseConnection);
            $migration = new ToDoMigration($databaseConnection);
            $api = new TodoApiController($toDoModel);
            $router = new Router($api, $migration);
            $router->route();
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'We can not connect to the database']);
        }
    }
}
 
$execute = new Main();
$execute->main();
