<?php

namespace App\Core;

use App\FilePath\FilePathProvider;
use App\Models\JsonModel;
use App\Models\MySQLModel;

class DataBase
{
    private jsonModel|MySQLModel $model;

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
            $filePathService = new FilePathProvider($connection['file_path']);
            $this->model = new JsonModel($filePathService);
        }
    }

    public function getModel(): MySQLModel|JsonModel
    {
        return $this->model;
    }
}