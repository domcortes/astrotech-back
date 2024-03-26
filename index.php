<?php
require_once 'Database.php';
require_once 'ToDoMigration.php';
require_once 'ToDoApi.php';
require_once 'Router.php';

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$databaseConnection = new DatabaseConnection();
$mysqli = $databaseConnection->getConnection();

if ($mysqli) {
    $connection = new DatabaseConnection();
    $migration = new TodoMigration($connection);
    $api = new TodoAPI($connection);
    $router = new Router($api, $migration);
    $router->route();
} else {
    http_response_code(500);
    echo json_encode(['error' => 'We can not connect to the database']);
}
?>