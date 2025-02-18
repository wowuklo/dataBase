<?php

namespace App\Core;

use App\FilePath\FilePathClass;
use App\Models\jsonModel;
use App\Models\MySQLModel;

class BD
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
            $filePathService = new FilePathClass($connection['file_path']);
            $this->model = new jsonModel($filePathService);
        }
    }

    public function getModel(): MySQLModel|jsonModel
    {
        return $this->model;
    }
}