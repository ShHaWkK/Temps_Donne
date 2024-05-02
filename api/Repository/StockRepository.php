<?php

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
            "UPDATE Stocks SET type_article = :type_article, quantite = :quantite, poids_total = :poids_total, poids_individuel = :poids_individuel, volume_total = :volume_total, volume_individuel = :volume_individuel, date_de_peremption = :date_de_peremption, emplacement = :emplacement, urgence = :urgence, date_de_reception = :date_de_reception, statut = :statut, ID_Don = :id_don, QR_Code = :qr_code WHERE ID_Stock = :id_stock" :
            "INSERT INTO Stocks (type_article, quantite, poids_total, poids_individuel, volume_total, volume_individuel, date_de_peremption, emplacement, urgence, date_de_reception, statut, ID_Don, QR_Code) VALUES (:type_article, :quantite, :poids_total, :poids_individuel, :volume_total, :volume_individuel, :date_de_peremption, :emplacement, :urgence, :date_de_reception, :statut, :id_don, :qr_code)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':type_article', $stock->type_article);
        $stmt->bindValue(':quantite', $stock->quantite);
        $stmt->bindValue(':poids_total', $stock->poids_total);
        $stmt->bindValue(':poids_individuel', $stock->poids_individuel);
        $stmt->bindValue(':volume_total', $stock->volume_total);
        $stmt->bindValue(':volume_individuel', $stock->volume_individuel);
        $stmt->bindValue(':date_de_peremption', $stock->date_de_peremption);
        $stmt->bindValue(':emplacement', $stock->emplacement);
        $stmt->bindValue(':urgence', $stock->urgence, PDO::PARAM_BOOL);
        $stmt->bindValue(':date_de_reception', $stock->date_de_reception);
        $stmt->bindValue(':statut', $stock->statut);
        $stmt->bindValue(':id_don', $stock->id_don);
        $stmt->bindValue(':qr_code', $stock->qr_code);
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
