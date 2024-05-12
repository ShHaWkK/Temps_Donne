<?php
class TrajetModel {
    public $id;
    public $nom;
    public $description;
    public $id_vehicule;
    public $horaires_debut;
    public $horaires_fin;
    public $type;
    public $plan;
    public $statut;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->nom = $data['nom'] ?? null;
        $this->description = $data['description'] ?? '';
        $this->id_vehicule = $data['id_vehicule'] ?? null;
        $this->horaires_debut = $data['horaires_debut'] ?? null;
        $this->horaires_fin = $data['horaires_fin'] ?? null;
        $this->type = $data['type'] ?? null;
        $this->plan = $data['plan'] ?? null;
        $this->statut = $data['statut'] ?? 'Planifié';
    }
}
?>
