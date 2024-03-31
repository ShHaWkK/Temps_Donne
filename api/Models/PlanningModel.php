<?php

class PlanningModel {
    public $ID_Planning;  
    public $ID_Utilisateur;
    public $activity;
    public $description;
    public $date;
    public $startTime;
    public $endTime;

    public function __construct($data = []) {
        $this->ID_Planning = $data['ID_Planning'] ?? null;
        $this->ID_Utilisateur = $data['ID_Utilisateur'] ?? null;
        $this->activity = $data['activity'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->date = $data['date'] ?? null;
        $this->startTime = $data['startTime'] ?? null;
        $this->endTime = $data['endTime'] ?? null;
    }
}

?>