<?php
namespace PresenceEngine\Middleware;

use PresenceEngine\Core\Session;

class GuestMiddleware
{
    public function handle(): bool
    {
        if (Session::has('user_id')) {
            $target = Session::get('role') === 'admin'
                ? '/PresenceEngine/public/admin'
                : '/PresenceEngine/public/me';
            header("Location: $target");
            return false;
        }
        return true;
    }
}