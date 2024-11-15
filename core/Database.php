<?php

declare(strict_types=1);

namespace App\Core;

use Exception;
use PDOException;
use PDO;

class Database
{
    public function __construct(
        private string $host = $_ENV['DB_HOST'],
        private string $db = $_ENV['DB_NAME'],
        private string $user = $_ENV['DB_USER'],
        private string $password = $_ENV['DB_PASSWORD'],
        private string $charset = $_ENV['DB_CHARSET']
    ) {}

    public function connection(): PDO
    {
        try {
            $connection = 'mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=' . $this->charset;
            $config = [
                PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES  => false
            ];
            $pdo = new PDO($connection, $this->user, $this->password, $config);
            return $pdo;
            
        } catch (PDOException $error) {
            throw new Exception('Error connection: ' . $error->getMessage());
        }
    }
}