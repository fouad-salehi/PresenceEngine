<?php
namespace PresenceEngine\Core;

class View
{
    public static function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    public static function csrfToken(): string
    {
        if (!Session::has('csrf_token')) {
            Session::set('csrf_token', bin2hex(random_bytes(32)));
        }
        return Session::get('csrf_token');
    }

    public static function verifyCsrf(?string $token): bool
    {
        return $token !== null
            && Session::has('csrf_token')
            && hash_equals(Session::get('csrf_token'), $token);
    }
}