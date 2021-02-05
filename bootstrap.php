<?php

/**
 * Bootstrap file
 * Declares necessary class that will be used in the app
 */

require 'vendor/autoload.php';

use Dotenv\Dotenv;

use App\Connection\Database;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database(
    $_ENV['DBTYPE'],
    $_ENV['HOST'],
    $_ENV['PORT'],
    $_ENV['DB'],
    $_ENV['USER'],
    $_ENV['PASSWORD']
);

$conn = $db->getConnection();
