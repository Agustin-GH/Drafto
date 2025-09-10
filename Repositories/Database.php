<?php

final class Database
{
    private static ?mysqli $conn = null;

    public static function get(): mysqli
    {
        if (self::$conn === null) {
            $config = require __DIR__ . '/../config/configuracion.php';
            $db = $config['db'];

            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            $conn = new mysqli(
                $db['host'] ?? 'localhost',
                $db['user'] ?? 'root',
                $db['pass'] ?? '',
                $db['database'] ?? '',
                (int)($db['port'] ?? 3306),
                $db['socket'] ?? null
            );
            
            $conn->set_charset($db['charset'] ?? 'utf8mb4');

            self::$conn = $conn;
        }
        return self::$conn;
    }
}