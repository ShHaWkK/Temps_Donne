<?php
class ServiceModel
{
    public $id_service;
    public $nom_du_service;
    public $description;
    public $horaire;
    public $lieu;
    public $id_utilisateur;
    public $nfc_Tag_Data;
    public $type_service;
    public $date_debut;
    public $date_fin;
    //public $roleName;

    public function __construct($data = [])
    {   $this->id_service = $data['ID_Service'] ?? null;
        $this->nom_du_service = $data['Nom_du_service'] ?? null;
        $this->description = $data['Description'] ?? null;
        $this->horaire = $data['Horaire'] ?? null;
        $this->lieu = $data['Lieu'] ?? null;
        $this->id_utilisateur = $data['ID_Utilisateur'] ?? null;
        $this->nfc_Tag_Data = $data['NFC_Tag_Data'] ?? null;
        $this->type_service = $data['Type_Service'] ?? null;
        $this->date_debut = $data['Date_Debut'] ?? null;
        $this->date_fin = $data['Date_Fin'] ?? null;
    }
}
?>