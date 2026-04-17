<?php

namespace Infrastructure\Persistence\MySQL;

use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=127.0.0.1;dbname=crud_usuarios;charset=utf8mb4',
                    'root',
                    '1234',
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
            } catch (PDOException $e) {
                die('Error de conexion a la base de datos: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
