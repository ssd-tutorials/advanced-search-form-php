<?php

require __DIR__ . "/../vendor/autoload.php";

use SSD\DotEnv\DotEnv;
use Illuminate\Http\Request;

use App\Container;
use App\Database\DatabaseManager;

$dotenv = new DotEnv(__DIR__.'/../.env');
$dotenv->overload();
$dotenv->required([
    'APP_ENV',
    'DB_CONNECTION',
    'DB_HOST',
    'DB_PORT',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD'
]);

Container::bind([
    'db' => DatabaseManager::make(),
    'request' => Request::capture()
]);