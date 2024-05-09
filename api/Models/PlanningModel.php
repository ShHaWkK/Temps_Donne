<?php
class PlanningModel {
    public $ID_Planning;
    public $ID_Utilisateur;
    public $ID_Service;
    public $description;
//    public $activity;
//    public $date;
//    public $startTime;
//    public $endTime;

    public function __construct($data = []) {
        $this->ID_Planning = $data['ID_Planning'] ?? null;
        $this->ID_Utilisateur = $data['ID_Utilisateur'] ?? null;
        $this->ID_Service = $data['ID_Service'] ?? null;
        $this->description = $data['description'] ?? null;
        /*
        $this->activity = $data['activity'] ?? null;
        $this->date = $data['date'] ?? null;
        $this->startTime = $data['startTime'] ?? null;
        $this->endTime = $data['endTime'] ?? null;
        */
    }
}

?>