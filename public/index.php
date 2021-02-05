<?php

require "../bootstrap.php";

use App\Controller\CarController;

//cross origin resource sharing script, allow all
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");
//output as json
header("Content-Type: application/json; charset=UTF-8");
//request method allowed
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
//cache results
header("Access-Control-Max-Age: 3600");


//get the url Path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

//get the request method if GET/POST/PUT/DELETE
$requestMethod = $_SERVER["REQUEST_METHOD"];

//check it ID is in param and check if numeric
$id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : 0;

//route declaration
switch ($uri[1]) {
    case 'car':
        // pass the request method to the car controller and process the HTTP request:
        $controller = new CarController($conn, $requestMethod, $id);
        $controller->processRequest();
        break;
    default:
        header("HTTP/1.1 200 OK");
        echo "Test API V1";
        break;
}
