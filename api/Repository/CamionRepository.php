<?php

require_once 'BDD.php';

class CamionRepository {
    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    //-------------------------------------------------------------------------------//

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM Camions");
        $success = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $success;
    }

    //-------------------------------------------------------------------------------//


    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Camions WHERE ID_Camion = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //-------------------------------------------------------------------------------//


    public function save(CamionModel $camion) {
        if ($camion->id_camion) {
            $sql = "UPDATE Camions SET immatriculation = :immatriculation, modele = :modele, ID_Entrepot = :id_entrepot, type = :type, statut = :statut, capacite_max = :capacite_max WHERE ID_Camion = :id_camion";
        } else {
            $sql = "INSERT INTO Camions (immatriculation, modele, ID_Entrepot, type, statut, capacite_max) VALUES (:immatriculation, :modele, :id_entrepot, :type, :statut, :capacite_max)";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':immatriculation', $camion->immatriculation);
        $stmt->bindValue(':modele', $camion->modele);
        $stmt->bindValue(':id_entrepot', $camion->id_entrepot);
        $stmt->bindValue(':type', $camion->type);
        $stmt->bindValue(':statut', $camion->statut);
        $stmt->bindValue(':capacite_max', $camion->capacite_max);
        if ($camion->id_camion) {
            $stmt->bindValue(':id_camion', $camion->id_camion, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $camion->id_camion ?? $this->db->lastInsertId();
    }

    //-------------------------------------------------------------------------------//
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Camions WHERE ID_Camion = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    //-------------------------------------------------------------------------------//

    public function getCamionByEntrepot($idEntrepot) {
        $stmt = $this->db->prepare("SELECT * FROM Camions WHERE ID_Entrepot = :idEntrepot");
        $stmt->execute(['idEntrepot' => $idEntrepot]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //-------------------------------------------------------------------------------//

    public function getCamionByType($type) {
        $stmt = $this->db->prepare("SELECT * FROM Camions WHERE type = :type");
        $stmt->execute(['type' => $type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //-------------------------------------------------------------------------------//

/*
*   // On choisit le camion avec la plus petite capacité qui peut gérer la tâche pour maximiser l'efficacité.
*/
    public function choisirCamionPourCollecte($idEntrepot, $capaciteNecessaire) {
        $sql = "SELECT * FROM Camions 
                WHERE ID_Entrepot = :idEntrepot 
                AND Capacite_Max >= :capacite 
                AND Statut = 'En service'
                ORDER BY Capacite_Max ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['idEntrepot' => $idEntrepot, 'capacite' => $capaciteNecessaire]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function trouverCamionsDisponibles($idEntrepot) {
        // pour obtenir des camions disponibles dans cet entrepôt
    }
}
?>