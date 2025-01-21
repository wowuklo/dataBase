<?php

namespace App;

require __DIR__ . "/vendor/autoload.php";

use App\Models\UserModel;
use App\Controllers\UserController;

$filePath = 'dataBase/data/user.json';
$model = new Models\UserModel($filePath);
$controller = new Controllers\UserController($model);

$command = $argv[1] ?? null;

switch ($command) {
    case 'show':
        $controller->showUsers();
        break;
    case 'add':
        $first_name = $argv[2] ?? 'Name';
        $last_name = $argv[3] ?? 'Surname';
        $email = $argv[4] ?? 'Email';
        $controller->addUser($first_name, $last_name, $email);
        break;
    case 'delete':
        $id = $argv[2] ?? null;
        if ($id) {
            $controller->deleteUser($id);
        } else {
            echo "specify the user id to delete.\n";
        }
        break;
    default:
        echo "Use: php index.php show | add <firstName> <lastName> <email> | delete <id>\n";
        break;

}




