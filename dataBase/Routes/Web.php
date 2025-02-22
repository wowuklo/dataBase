<?php

namespace App\Routes;

use App\Core\Router;
use App\controllers\UserController;


class Web
{
    public static function registerRoutes(Router $router, UserController $userController): void
    {
        $router->addRoute('GET', '/list-users', [$userController, 'showUsers']);
        $router->addRoute('DELETE', '/delete-user/{id}', [$userController, 'deleteUser']);
        $router->addRoute('POST', '/create-user', [$userController, 'addUser']);
    }
}