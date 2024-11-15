<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Database;
use PDOException;
use PDOStatement;

class Model
{
    public function __construct(
        private Database $db = new Database()
    ) {
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