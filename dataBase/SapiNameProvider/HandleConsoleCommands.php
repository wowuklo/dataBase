<?php

namespace App\SapiNameProvider;

use App\Controllers\UserController;
use App\Interface\DataSourceInterface;
use App\Models\JsonModel;


class HandleConsoleCommands
{
    public function __construct(private readonly DataSourceInterface $model)
    {

    }

    public function handleConsoleCommands(array $argv): void
    {
        $command = $argv[1] ?? null;
        $args = array_slice($argv, 2);

        $userController = new UserController($this->model);

        switch ($command) {
            case 'list-users':
                $userController->showUsers();
                break;

            case 'create-user':
                if (count($args) < 2) {
                    echo "Usage: php index.php create-user <firstName> <lastName> <email>\n";
                } else {
                    $userController->addUser();
                }
                break;

            case 'delete-user':
                if (count($args) < 1) {
                    echo "Usage: php index.php delete-user <id>\n";
                } else {
                    $userController->deleteUser((int)$args[0]);
                }
                break;

            default:
                echo "All commands:\n";
                echo " - list-users\n";
                echo " - create-user <firstName> <lastName> <email>\n";
                echo " - delete-user <id>\n";
                break;


        }
    }
}