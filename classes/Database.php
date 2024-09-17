<?php
class Database
{
    private $db;

    public function __construct($config)
    {
        try {
            $this->db = new PDO("{$config['driver']}:host={$config['host']};dbname={$config['database']}", "{$config['username']}", "{$config['password']}");
        } catch (PDOException $e) {
            die('Database connection error: ' . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->db;
    }
}

