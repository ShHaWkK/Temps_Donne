<?php
class EntrepotModel {
    public $id;
    public $nom;
    public $adresse;
    public $taille;
    public $nb_etageres;
    public $nb_etageres_max;
    public $nb_etageres_remplie;
    public $place_restante;
    public $latitude;
    public $longitude;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->nom = $data['nom'] ?? null;
        $this->adresse = $data['adresse'] ?? null;
        $this->taille = $data['taille'] ?? 0.0;
        $this->nb_etageres = $data['nb_etageres'] ?? 0;
        $this->nb_etageres_max = $data['nb_etageres_max'] ?? 0;
        $this->nb_etageres_remplie = $data['nb_etageres_remplie'] ?? 0;
        $this->place_restante = $data['place_restante'] ?? 0.0;
        $this->latitude = $data['latitude'] ?? null;
        $this->longitude = $data['longitude'] ?? null;
    }
}
?>
