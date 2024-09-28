<?php

use config\Database;
use PDOException;

class Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function query($query)
    {
        try {
            return $this->db->connection()->query($query);
        } catch (PDOException $error) {
            throw new Exception('Error query: ' . $error);
        }
    }

    public function prepare($query)
    {
        try {
            return $this->db->connection()->prepare($query);
        } catch (PDOException $error) {
            throw new Exception('Error prepare query: ' .$error);
        }
    }
}