<?php

// Path: api/Repository/StockRepository.php


require_once 'BDD.php'; 


class StockRepository {
    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    public function findAll() {
        $sql = "SELECT * FROM Stocks";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Retourne null pour indiquer une erreur
            return null;
        }
    }

    public function findById($id) {
        $sql = "SELECT * FROM Stocks WHERE ID_Stock = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Retourne null pour indiquer une erreur
            return null;
        }
    }

    public function save(array $stockData) {
        $sql = isset($stockData['id_stock']) 
            ? "UPDATE Stocks SET type_article = :type_article, quantite = :quantite, date_peremption = :date_peremption, emplacement = :emplacement WHERE ID_Stock = :id_stock"
            : "INSERT INTO Stocks (type_article, quantite, date_peremption, emplacement) VALUES (:type_article, :quantite, :date_peremption, :emplacement)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id_stock' => $stockData['id_stock'] ?? null,
                ':type_article' => $stockData['type_article'],
                ':quantite' => $stockData['quantite'],
                ':date_peremption' => $stockData['date_peremption'],
                ':emplacement' => $stockData['emplacement'],
            ]);

            if (!isset($stockData['id_stock'])) {
                return $this->db->lastInsertId();
            }

            return $stockData['id_stock'];
        } catch (PDOException $e) {
            // Retourne false pour indiquer une erreur
            return false;
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM Stocks WHERE ID_Stock = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // Retourne false pour indiquer une erreur
            return false;
        }
    }
}

?>
