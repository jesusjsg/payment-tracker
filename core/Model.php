<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Database;
use PDOException;
use Exception;
use PDOStatement;

class Model
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function query(string $query): PDOStatement
    {
        try {
            return $this->db->connection()->query($query);
        } catch (PDOException $error) {
            throw new PDOException('Error query: ' . $error);
        }
    }

    public function prepare(string $query): PDOStatement
    {
        try {
            return $this->db->connection()->prepare($query);
        } catch (PDOException $error) {
            throw new PDOException('Error prepare query: ' .$error);
        }
    }
}