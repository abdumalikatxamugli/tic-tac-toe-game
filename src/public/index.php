<?php

declare(strict_types = 1);
require __DIR__."/../vendor/autoload.php";
require __DIR__."/../app/helpers/auth_helpers.php";

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Database;
use App\Router;
use Dotenv\Dotenv;

session_start();

$database = new Database();
$config = Dotenv::createImmutable(dirname(__DIR__))->load();
Database::connect($config);

$router = new Router();

$router->register('/login', [AuthController::class, 'showLoginPage']);  
$router->register('/loginUser', [AuthController::class, 'login']);
$router->register('/register', [AuthController::class, 'showRegisterPage']);
$router->register('/registerUser', [AuthController::class, 'register']);
$router->register('/logout', [AuthController::class, 'logout']);

$router->register('/', [HomeController::class, 'home'])->protect();
$router->register('/gameplay', [HomeController::class, 'gameplay'])->protect();
$router->register('/gamewatch', [HomeController::class, 'gamewatch'])->protect();
$router->register('/makemove', [HomeController::class, 'makemove'])->protect();
$router->register('/profile', [HomeController::class, 'profile'])->protect();
$router->register('/topPlayers', [HomeController::class, 'topPlayers'])->protect();
$router->register('/topGroups', [HomeController::class, 'topGroups'])->protect();
$router->register('/childGroups', [HomeController::class, 'childGroups'])->protect();

$router->register('/photoUpload', [UserController::class, 'photoUpload'])->protect();
$router->register('/photoUploadSave', [UserController::class, 'photoUploadSave'])->protect();
$router->register('/createGroup', [UserController::class, 'createGroup'])->protect();
$router->register('/saveGroup', [UserController::class, 'saveGroup'])->protect();


$router->resolve($_SERVER['REQUEST_URI']);