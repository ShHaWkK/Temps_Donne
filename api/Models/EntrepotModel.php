<?php
class EntrepotModel {
    public $id;
    public $nom;
    public $adresse;
    public $volumeTotal;
    public $volumeUtilise;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->nom = $data['Nom'] ?? null;
        $this->adresse = $data['Adresse'] ?? null;
        $this->volumeTotal = $data['Volume_Total'] ?? 0.0;
        $this->volumeUtilise = $data['Volume_Utilise'] ?? 0.0;
    }

}


?>
