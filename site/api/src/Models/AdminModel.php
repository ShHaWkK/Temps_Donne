<?php

require_once '../config/database.php';
require_once '../Models/Admin.php';


class AdminModel {
    public $ID_Administrateur;
    public $Nom;
    public $Prenom;
    public $Email;
    public $Mot_de_passe;
    public $Role;
    public $Photo_Profil;

    public function __construct($id, $nom, $prenom, $email, $mot_de_passe, $role, $photo_profil) {
        $this->ID_Administrateur = $id;
        $this->Nom = $nom;
        $this->Prenom = $prenom;
        $this->Email = $email;
        $this->Mot_de_passe = $mot_de_passe;
        $this->Role = $role;
        $this->Photo_Profil = $photo_profil;
    }
}
?>
