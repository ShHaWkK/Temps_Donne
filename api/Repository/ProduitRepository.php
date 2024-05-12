<?php

require_once 'BDD.php';

class ProduitRepository {
    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM Produits");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $sql = "SELECT * FROM Produits WHERE ID_Produit = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function save(ProduitModel $produit) {
        if ($produit->id_produit) {
            $sql = "UPDATE Produits SET nom_produit = :nom_produit, description = :description, prix = :prix, volume = :volume, poids = :poids WHERE ID_Produit = :id_produit";
        } else {
            $sql = "INSERT INTO Produits (nom_produit, description, prix, volume, poids) VALUES (:nom_produit, :description, :prix, :volume, :poids)";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nom_produit', $produit->nom_produit);
        $stmt->bindValue(':description', $produit->description);
        $stmt->bindValue(':prix', $produit->prix);
        $stmt->bindValue(':volume', $produit->volume);
        $stmt->bindValue(':poids', $produit->poids);
        if ($produit->id_produit) {
            $stmt->bindValue(':id_produit', $produit->id_produit, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $produit->id_produit ?? $this->db->lastInsertId();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Produits WHERE ID_Produit = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>