<?php

class CommercantModel {
    public $id;
    public $nom;
    public $adresse;
    public $contrat;

    public function __construct($data) {
        $this->id = $data['ID_Commercant'] ?? null;
        $this->nom = $data['Nom'];
        $this->adresse = $data['Adresse'];
        $this->contrat = $data['Contrat'];
    }
}

?>