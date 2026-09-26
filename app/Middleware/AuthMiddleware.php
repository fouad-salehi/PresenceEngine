<?php
namespace PresenceEngine\Middleware;

use PresenceEngine\Core\Session;

class AuthMiddleware
{
    public function handle(): bool
    {
        if (!Session::has('user_id')) {
            header('Location: /PresenceEngine/public/login');
            return false;
        }
        return true;
    }
}