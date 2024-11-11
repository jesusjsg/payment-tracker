<?php

declare(strict_types=1);

namespace App\Core;

use Exception;
use PDOException;
use PDO;

class Database
{
    private string $host;
    private string $db;
    private string $user;
    private string $password;
    private string $charset;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->db = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->charset = $_ENV['DB_CHARSET'];
    }

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