<?php

require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Database {
    private $host;
    private $db;
    private $user;
    private $password;
    private $connection;

    public function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->db = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->connection = $this->getConnection();
    }

    private function getConnection() {
        try {
            $dsn = "pgsql:host={$this->host};dbname={$this->db}";

            return new PDO(
                $dsn,
                $this->user,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function getConnectionInstance() {
        return $this->connection;
    }
}
?>