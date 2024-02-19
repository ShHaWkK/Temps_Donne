<?php


// file: api/src/Repository/StockRepository.php


require_once '../config/database.php';


class StockRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addStock($stockData) {
        $query = "INSERT INTO stocks (Type_article, Quantite, Date_de_peremption, Emplacement, Urgence, Date_de_reception, ID_Don, QR_Code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $stockData['Type_article'],
            $stockData['Quantite'],
            $stockData['Date_de_peremption'],
            $stockData['Emplacement'],
            $stockData['Urgence'],
            $stockData['Date_de_reception'],
            $stockData['ID_Don'],
            $stockData['QR_Code']
        ]);
        return $this->db->lastInsertId();
    }

    public function updateStock($id, $stockData) {
        $query = "UPDATE stocks SET Type_article = ?, Quantite = ?, Date_de_peremption = ?, Emplacement = ?, Urgence = ?, Date_de_reception = ?, ID_Don = ?, QR_Code = ? WHERE ID_Stock = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $stockData['Type_article'],
            $stockData['Quantite'],
            $stockData['Date_de_peremption'],
            $stockData['Emplacement'],
            $stockData['Urgence'],
            $stockData['Date_de_reception'],
            $stockData['ID_Don'],
            $stockData['QR_Code'],
            $id
        ]);
    }

    public function deleteStock($id) {
        $query = "DELETE FROM stocks WHERE ID_Stock = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }

    public function getStockById($id) {
        $query = "SELECT * FROM stocks WHERE ID_Stock = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllStocks() {
        $query = "SELECT * FROM stocks";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStockByDonId($id) {
        $query = "SELECT * FROM stocks WHERE ID_Don = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>