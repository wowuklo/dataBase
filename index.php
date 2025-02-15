<?php

namespace App;

require __DIR__ . "/vendor/autoload.php";

use App\Models\UserModel;
use App\Controllers\UserController;
use App\Models\MySQLModel;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbSourse = $_ENV['DB_SOURCE'] ?? 'json';

$routes = [
    'GET /list-users' => 'UserController:showUsers',
    'DELETE /delete-user/{id}' => 'UserController:deleteUser',
    'POST /create-user' => 'UserController:addUser',
];

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($dbSourse === "mysql") {
    $model = new MySQLModel(
        $_ENV['DB_HOST'],
        $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
    );
} else {
    $filePath = 'dataBase/data/user.json';
    $model = new UserModel($filePath);
}

$controller = new UserController($model);

$matches = false;

foreach ($routes as $route => $action) {
    list($routeMethod, $routeUri) = explode(' ', $route, 2);

    $routePattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $routeUri);
    $routePattern = str_replace('/', '\/', $routePattern);

    if ($method === $routeMethod && preg_match("#^$routePattern$#", $uri, $matches)) {
        list($controllerName, $methodName) = explode(':', $action);

        array_shift($matches);
        $matches = array_map('intval', $matches);

        error_log("Route matched: $routeMethod $routeUri");
        error_log("URI: $uri");
        error_log("Matches: " . print_r($matches, true));
        call_user_func_array([$controller, $methodName], $matches);

        $matches = true;
        break;
    }
}

if (!$matches) {
    http_response_code(404);
    echo json_encode(['message' => '404 Not Found']);
}