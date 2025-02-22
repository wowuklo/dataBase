<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use App\FilePath\FilePathProvider;
use App\SapiNameProvider\HandleConsoleCommands;
use App\SapiNameProvider\HandleHttpRequest;
use App\SapiNameProvider\AppContext;
use App\Models\JsonModel;

$config = new FilePathProvider();
$model = new JsonModel($config);


if (php_sapi_name() == 'cli') {
    AppContext::$isCLi = true;
    $console = new HandleConsoleCommands($model);
    $console->handleConsoleCommands($argv);
} else {
    $request = new HandleHttpRequest();
    $request->handleHttpRequest();
}



