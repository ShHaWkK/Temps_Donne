<?php

class CamionModel {
    public $id_camion;
    public $immatriculation;
    public $modele;
    public $id_entrepot;
    public $type;
    public $statut;
    public $capacite_max;

    public function __construct($data) {
        $this->id_camion = $data['id_camion'] ?? null;
        $this->immatriculation = $data['immatriculation'];
        $this->modele = $data['modele'];
        $this->id_entrepot = $data['id_entrepot'];
        $this->type = $data['type'];
        $this->statut = $data['statut'];
        $this->capacite_max = $data['capacite_max'];
    }
}
?>s