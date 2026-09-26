<?php
namespace PresenceEngine\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host    = Config::get('DB_HOST');
            $port    = Config::get('DB_PORT', '3306');
            $name    = Config::get('DB_NAME');
            $user    = Config::get('DB_USER');
            $pass    = Config::get('DB_PASS', '');
            $charset = Config::get('DB_CHARSET', 'utf8mb4');

            $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=$charset";

            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die('DB connection failed: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}