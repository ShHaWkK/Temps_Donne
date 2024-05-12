<?php

class ProduitModel {
    public $id_produit;
    public $nom_produit;
    public $description;
    public $prix;
    public $volume;
    public $poids;

    public function __construct($data) {
        $this->id_produit = $data['id_produit'] ?? null;
        $this->nom_produit = $data['nom_produit'];
        $this->description = $data['description'] ?? '';
        $this->prix = $data['prix'];
        $this->volume = $data['volume'];
        $this->poids = $data['poids'];
    }
}
?>