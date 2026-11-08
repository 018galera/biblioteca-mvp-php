<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    /** @var Database|null */
    private static $instance = null;

    /** @var PDO */
    private $conn;

    private $host = "localhost";
    private $dbname = "biblioteca_mvp";
    private $user = "root";
    private $pass = "";
    private $charset = "utf8mb4";

    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die("<div style='background:#fee2e2;color:#991b1b;padding:20px;font-family:sans-serif;'>
                    <h3>Erro Crítico no Banco de Dados</h3>
                    <p>Não foi possível conectar. Detalhes: " . htmlspecialchars($e->getMessage()) . "</p>
                 </div>");
        }
    }

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}