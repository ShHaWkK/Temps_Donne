<?php


class CamionService {
    private $db;
    private $camionRepository;

    public function __construct($db) {
        $this->db = $db;
        $this->camionRepository=new CamionRepository();
    }

    public function choisirCamionPourCollecte($volumeNecessaire, $idEntrepot) {
        return $this->camionRepository->trouverCamionsDisponibles($idEntrepot, $volumeNecessaire);
    }

    public function getAllCamions()
    {
        return $this->camionRepository->findAll();
    }

}

?>

