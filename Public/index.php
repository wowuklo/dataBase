<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\UserController;
use App\Core\Router;
use App\Core\BD;
use App\Routes\Web;


$config = require __DIR__ . "/../config/InitializeDB.php";

$db = new BD($config);

$userController = new UserController($db->getModel());

$router = new Router();
Web::registerRoutes($router, $userController);

$router->dispatch();


