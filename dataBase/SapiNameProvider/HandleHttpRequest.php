<?php

namespace App\SapiNameProvider;

use App\Controllers\UserController;
use App\Core\DataBase;
use App\Core\Router;
use App\Routes\Web;

class HandleHttpRequest
{

    public function handleHttpRequest(): void
    {
        $config = require __DIR__ . "/../../config/InitializeDB.php";

        $db = new DataBase($config);

        $userController = new UserController($db->getModel());

        $router = new Router();
        Web::registerRoutes($router, $userController);

        $router->dispatch();
    }

}