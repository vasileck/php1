<?php

class CProducts {
    private $db;

    public function __construct() {
        $config = require 'config.php';

        try {
            $this->db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4",
                $config['db_user'],
                $config['db_password']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getProducts($limit = 10) {
        $stmt = $this->db->prepare("SELECT * FROM Products WHERE IS_HIDDEN = 0 ORDER BY DATE_CREATE DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function hideProduct($id) {
        $stmt = $this->db->prepare("UPDATE Products SET IS_HIDDEN = 1 WHERE ID = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateProductQuantity($id, $quantity) {
        $stmt = $this->db->prepare("UPDATE Products SET PRODUCT_QUANTITY = :quantity WHERE ID = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', (int)$quantity, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>
