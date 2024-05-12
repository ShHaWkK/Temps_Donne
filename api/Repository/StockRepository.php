<?php

require_once 'BDD.php';

class StockRepository {
    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    public function findAll() {
        $sql = "SELECT * FROM Stocks";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $sql = "SELECT * FROM Stocks WHERE ID_Stock = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function save(StockModel $stock) {
        $sql = is_null($stock->id_stock) ?
            "INSERT INTO Stocks (ID_Entrepots, ID_Produit, Quantite, Poids_Total, Volume_Total, Date_de_reception, Statut, QR_Code, Date_de_peremption) VALUES (:id_entrepot, :id_produit, :quantite, :poids_total, :volume_total, :date_de_reception, :statut, :qr_code, :date_de_peremption)" :
            "UPDATE Stocks SET ID_Entrepots = :id_entrepot, ID_Produit = :id_produit, Quantite = :quantite, Poids_Total = :poids_total, Volume_Total = :volume_total, Date_de_reception = :date_de_reception, Statut = :statut, QR_Code = :qr_code, Date_de_peremption = :date_de_peremption WHERE ID_Stock = :id_stock";
        $stmt = $this->db->prepare($sql);
        if (!is_null($stock->id_stock)) {
            $stmt->bindValue(':id_stock', $stock->id_stock, PDO::PARAM_INT);
        }
        $stmt->bindValue(':id_entrepot', $stock->id_entrepot);
        $stmt->bindValue(':id_produit', $stock->id_produit);
        $stmt->bindValue(':quantite', $stock->quantite);
        $stmt->bindValue(':poids_total', $stock->poids_total);
        $stmt->bindValue(':volume_total', $stock->volume_total);
        $stmt->bindValue(':date_de_reception', $stock->date_de_reception);
        $stmt->bindValue(':statut', $stock->statut);
        $stmt->bindValue(':qr_code', $stock->qr_code);
        $stmt->bindValue(':date_de_peremption', $stock->date_de_peremption);
        $stmt->execute();
        return $stock->id_stock ? $stock->id_stock : $this->db->lastInsertId();
    }

    public function delete($id) {
        $sql = "DELETE FROM Stocks WHERE ID_Stock = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function findByCriteria($criteria) {
        $sql = "SELECT * FROM Stocks WHERE ";
        $conditions = [];
        $params = [];
        foreach ($criteria as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $sql .= implode(' AND ', $conditions);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nouvelle méthode pour mettre à jour le chemin QR Code dans la base de données
    public function updateQrCodePath($id, $path) {
        $stmt = $this->db->prepare("UPDATE Stocks SET qr_code = :path WHERE id_stock = :id");
        $stmt->execute([':path' => $path, ':id' => $id]);
    }

}


?>
