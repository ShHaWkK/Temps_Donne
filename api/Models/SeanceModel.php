<?php

class SeanceModel
{
    public $description;
    public $id_seance;

    public $id_formation;

    public $id_salle;

    public $date;
    public $heure_debut;
    public $heure_fin;

    public function __construct($formation) {
        $this->id_seance = $formation['Seance'] ?? null;
        $this->id_formation = $formation['ID_Formation'] ?? null;
        $this->id_salle = $formation['ID_Salle'] ?? null;
        $this->description = $formation['Description'] ?? null;
        $this->date = $formation['Date'] ?? null;
        $this->heure_debut = $formation['Heure_Debut_Seance'] ?? null;
        $this->heure_fin = $formation['Heure_Fin_Seance'] ?? null;
    }

}