<?php

/**
 * Bootstrap file
 * Declares necessary class that will be used in the app
 */

require 'vendor/autoload.php';

use App\Connection\Database;

$db = new Database(
    getenv('DBTYPE'),
    getenv('HOST'),
    getenv('PORT'),
    getenv('DB'),
    getenv('USER'),
    getenv('PASSWORD')
);

$conn = $db->getConnection();
