<?php


class CamionService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function choisirCamionPourCollecte($idEntrepot, $capaciteNecessaire) {
        $sql = "SELECT * FROM Camions 
                WHERE ID_Entrepot = :idEntrepot 
                AND Capacite_Max >= :capacite 
                AND Statut = 'En service'
                ORDER BY Capacite_Max ASC";  // On choisit le camion avec la plus petite capacité qui peut gérer la tâche pour maximiser l'efficacité.
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['idEntrepot' => $idEntrepot, 'capacite' => $capaciteNecessaire]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>

