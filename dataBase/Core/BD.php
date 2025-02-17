<?php

namespace App\Core;

use App\Models\UserModel;
use App\Models\MySQLModel;

class BD
{
    private UserModel|MySQLModel $model;

    public function __construct(array $config)
    {
        $default = $config['default'];
        $connection = $config['connections'][$default];

        if ($default === 'mysql') {
            $this->model = new MySQLModel(
                $connection['host'],
                $connection['dbname'],
                $connection['user'],
                $connection['password']
            );
        } else {
            $this->model = new UserModel($connection['file_path']);
        }
    }

    public function getModel(): MySQLModel|UserModel
    {
        return $this->model;
    }
}