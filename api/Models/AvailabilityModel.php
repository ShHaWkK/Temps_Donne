<?php
class AvailabilityModel {
    public $id;
    public $id_utilisateur;
    public $demi_journees;
    public $lundi;
    public $mardi;
    public $mercredi;
    public $jeudi;
    public $vendredi;
    public $samedi;
    public $dimanche;

    public function __construct($data,$id_utilisateur) {
        $this->id = $data['ID_Disponibilite'] ?? null;
        $this->id_utilisateur = $id_utilisateur ?? null;
        $this->demi_journees = $data['DEMI_JOURNEES'] ?? 0;
        $this->lundi = $data['LUNDI'] ?? false;
        $this->mardi = $data['MARDI'] ?? false;
        $this->mercredi = $data['MERCREDI'] ?? false;
        $this->jeudi = $data['JEUDI'] ?? false;
        $this->vendredi = $data['VENDREDI'] ?? false;
        $this->samedi = $data['SAMEDI'] ?? false;
        $this->dimanche = $data['DIMANCHE'] ?? false;
    }
}
?>
