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

    public function save(StockModel $stock) {
        $sql = $stock->id_stock ? 
            "UPDATE Stocks SET type_article = :type_article, quantite = :quantite, date_de_peremption = :date_de_peremption, urgence = :urgence, ID_Don = :id_don WHERE ID_Stock = :id_stock" :
            "INSERT INTO Stocks (type_article, quantite, date_de_peremption, urgence, ID_Don) VALUES (:type_article, :quantite, :date_de_peremption, :urgence, :id_don)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':type_article', $stock->type_article);
        $stmt->bindValue(':quantite', $stock->quantite);
        $stmt->bindValue(':date_de_peremption', $stock->date_de_peremption);
        $stmt->bindValue(':urgence', $stock->urgence, PDO::PARAM_BOOL);
        $stmt->bindValue(':id_don', $stock->id_don);
        if ($stock->id_stock) {
            $stmt->bindValue(':id_stock', $stock->id_stock, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stock->id_stock ?? $this->db->lastInsertId();
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

    public function updateQrCodePath($stockId, $qrCodePath) {
        $sql = "UPDATE Stocks SET QR_Code = :qr_code WHERE ID_Stock = :id_stock";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':qr_code' => $qrCodePath,
            ':id_stock' => $stockId
        ]);
    }
}

?>
