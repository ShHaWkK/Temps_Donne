<?php
class ServiceModel
{
    public $id_service;
    public $nom_du_service;
    public $description;
    public $horaire;
    public $lieu;
    public $date;
    public $id_serviceType;
    public $startTime;
    public $endTime;

    public function __construct($id_type,$data = [])
    {
        $this->id_service = $data['ID_Service'] ?? null;
        $this->nom_du_service = $data['Nom_du_service'] ?? null;
        $this->description = $data['Description'] ?? null;
        $this->horaire = $data['Horaire'] ?? null;
        $this->lieu = $data['Lieu'] ?? null;
        $this->date = $data['Date'] ?? null;
        $this->id_serviceType = $id_type ?? null;
        $this->startTime = $data['startTime'] ?? null;
        $this->endTime = $data['endTime'] ?? null;
    }
}