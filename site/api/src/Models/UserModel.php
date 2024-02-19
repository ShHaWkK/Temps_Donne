<?php
// file: api/src/Models/UserModel.php


require_once '../config/database.php';


// file: api/src/Models/UserModel.php
class UserModel {
    public $ID_Utilisateur;
    public $Nom;
    public $Prenom;
    public $Email;
    public $Mot_de_passe;
    public $Role;
    public $Adresse;
    public $Telephone;
    public $Date_de_naissance;
    public $Langues;
    public $Nationalite;
    public $Date_d_inscription;
    public $Statut;
    public $Situation;
    public $Besoins_specifiques;
    public $Photo_Profil;
    public $Date_Derniere_Connexion;
    public $Statut_Connexion;
    public $Emploi;
    public $Societe;

    public function __construct($data) {
        $this->ID_Utilisateur = $data['ID_Utilisateur'] ?? null;
        $this->Nom = $data['Nom'] ?? '';
        $this->Prenom = $data['Prenom'] ?? '';
        $this->Email = $data['Email'] ?? '';
        $this->Mot_de_passe = $data['Mot_de_passe'] ?? '';
        $this->Role = $data['Role'] ?? '';
        $this->Adresse = $data['Adresse'] ?? '';
        $this->Telephone = $data['Telephone'] ?? '';
        $this->Date_de_naissance = $data['Date_de_naissance'] ?? '';
        $this->Langues = $data['Langues'] ?? '';
        $this->Nationalite = $data['Nationalite'] ?? '';
        $this->Date_d_inscription = $data['Date_d_inscription'] ?? '';
        $this->Statut = $data['Statut'] ?? '';
        $this->Situation = $data['Situation'] ?? '';
        $this->Besoins_specifiques = $data['Besoins_specifiques'] ?? '';
        $this->Photo_Profil = $data['Photo_Profil'] ?? '';
        $this->Date_Derniere_Connexion = $data['Date_Derniere_Connexion'] ?? '';
        $this->Statut_Connexion = $data['Statut_Connexion'] ?? '';
        $this->Emploi = $data['Emploi'] ?? '';
        $this->Societe = $data['Societe'] ?? '';
    }
}

?>