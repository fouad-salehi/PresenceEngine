<?php
require __DIR__ . '/../vendor/autoload.php';

use PresenceEngine\Core\Config;
use PresenceEngine\Core\Router;
use PresenceEngine\Core\Session;
use PresenceEngine\Controllers\AuthController;
use PresenceEngine\Controllers\UserController;
use PresenceEngine\Controllers\AdminController;
use PresenceEngine\Middleware\AuthMiddleware;
use PresenceEngine\Middleware\AdminMiddleware;
use PresenceEngine\Middleware\GuestMiddleware;

Config::load(__DIR__ . '/..');
Session::start();

$router = new Router();

$router->get('/login',   [AuthController::class, 'showLogin'], [GuestMiddleware::class]);
$router->post('/login',  [AuthController::class, 'login'],     [GuestMiddleware::class]);
$router->post('/logout', [AuthController::class, 'logout'],    [AuthMiddleware::class]);

$router->get('/me',      [UserController::class, 'dashboard'], [AuthMiddleware::class]);

$router->get('/admin',                    [AdminController::class, 'dashboard'],      [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/history',            [AdminController::class, 'history'],        [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/api/presence',       [AdminController::class, 'apiPresence'],    [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/api/stats',          [AdminController::class, 'apiStats'],       [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/users',              [AdminController::class, 'listUsers'],      [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/users/create',       [AdminController::class, 'showCreateUser'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/users',             [AdminController::class, 'storeUser'],      [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/users/{id}/toggle', [AdminController::class, 'toggleUser'],     [AuthMiddleware::class, AdminMiddleware::class]);

$router->get('/', function() {
    header('Location: /PresenceEngine/public/login');
    exit;
});

$basePath = '/PresenceEngine/public';
$uri = $_SERVER['REQUEST_URI'];
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}
if ($uri === '' || $uri === false) {
    $uri = '/';
}
$router->dispatch($_SERVER['REQUEST_METHOD'], $uri);