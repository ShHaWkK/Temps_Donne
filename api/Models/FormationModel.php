<?php 

class FormationModel {
    public $id;
    public $titre;
    public $description;
    public $dateFormation;
    public $duree;
    public $lieu;
    public $idOrganisateur;

   public function __construct($formation) {
    $this->id = $formation['ID_Formation'] ?? null;
    $this->titre = $formation['Titre'] ?? null;
    $this->description = $formation['Description'] ?? null;
    $this->dateFormation = $formation['Date_Formation'] ?? null;
    $this->duree = $formation['Duree'] ?? null;
    $this->lieu = $formation['Lieu'] ?? null;
    $this->idOrganisateur = $formation['ID_Organisateur'] ?? null;
}

}
?>