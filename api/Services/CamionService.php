<?php


class CamionService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function choisirCamionPourCollecte($volumeNecessaire, $idEntrepot) {
        return $this->camionRepository->trouverCamionsDisponibles($idEntrepot, $volumeNecessaire);
    }

}

?>

