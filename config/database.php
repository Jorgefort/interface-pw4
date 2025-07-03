<?php

class Database {
    private $db_file = 'database/products.db';
    private $pdo = null;
    
    public function __construct() {
        $this->connect();
        $this->createTables();
    }
    
    private function connect() {
        try {
            $db_dir = dirname($this->db_file);
            if (!is_dir($db_dir)) {
                mkdir($db_dir, 0755, true);
            }
            
            $this->pdo = new PDO('sqlite:' . $this->db_file);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    
    private function createTables() {
        $sql = "CREATE TABLE IF NOT EXISTS producten (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            naam TEXT NOT NULL,
            omschrijving TEXT,
            maat TEXT CHECK(maat IN ('XS', 'S', 'M', 'L', 'XL')),
            afbeelding TEXT,
            prijs INTEGER
        )";
        
        try {
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            die('Table creation failed: ' . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->pdo;
    }
}
