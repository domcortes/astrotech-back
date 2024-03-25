<?php
require_once 'Database.php';
require_once 'ToDoMigration.php';
require_once 'ToDoApi.php';
require_once 'Router.php';

$databaseConnection = new DatabaseConnection();
$mysqli = $databaseConnection->getConnection();

if ($mysqli) {
    $connection = new DatabaseConnection();
    $api = new TodoAPI($connection);
    $router = new Router($api);
    $router->route();
} else {
    http_response_code(500);
    echo json_encode(['error' => 'We can not connect to the database']);
}
?>