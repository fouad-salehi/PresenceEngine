<?php
namespace PresenceEngine\Middleware;

use PresenceEngine\Core\Session;

class AdminMiddleware
{
    public function handle(): bool
    {
        if (Session::get('role') !== 'admin') {
            http_response_code(403);
            require __DIR__ . '/../Views/errors/403.php';
            return false;
        }
        return true;
    }
}