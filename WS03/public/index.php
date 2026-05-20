<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use Framework\Router;
use Framework\Session;

Session::start();

require '../helpers.php';

//instatiate the router
$router = new Router();

//get routes
$routes = require basePath('routes.php');

//get burrent url and http method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//router the request
$router->route($uri);
