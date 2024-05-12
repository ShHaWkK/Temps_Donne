<?php

class FormationModel {
    public $id;
    public $titre;
    public $description;
    public $dateDebut;
    public $dateFin;
    public $idOrganisateur;

    public function __construct($formation) {
        $this->id = $formation['ID_Formation'] ?? null;
        $this->titre = $formation['Titre'] ?? null;
        $this->description = $formation['Description'] ?? null;
        $this->dateDebut = $formation['Date_Debut_Formation'] ?? null;
        $this->dateFin = $formation['Date_Fin_Formation'] ?? null;
        $this->idOrganisateur = $formation['ID_Organisateur'] ?? null;
    }

}
?>