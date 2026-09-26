<?php
namespace PresenceEngine\Core;

use Dotenv\Dotenv;

class Config
{
    private static array $values = [];

    public static function load(string $path): void
    {
        $dotenv = Dotenv::createImmutable($path);
        $dotenv->load();
        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER']);
        self::$values = $_ENV;
    }

    public static function get(string $key, $default = null)
    {
        return self::$values[$key] ?? $default;
    }
}