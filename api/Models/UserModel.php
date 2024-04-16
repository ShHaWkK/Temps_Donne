<?php

class UserModel {
    public $nom;
    public $prenom;
    public $email;
    public $mot_de_passe;
    public $adresse;
    public $telephone;
    public $date_de_naissance;
    public $langues;
    public $nationalite;
    public $date_d_inscription;
    public $statut; // Actif ou inactif
    public $situation;
    public $besoins_specifiques;
    public $photo_profil;
    public $date_derniere_connexion;
    public $statut_connexion; // Connecté ou déconnecté
    public $emploi;
    public $societe;
    public $code_verification;
    public $type_permis;
    //public $roleName;

    public function __construct($data = []) {
        $this->nom = $data['nom'] ?? null;
        $this->prenom = $data['prenom'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->mot_de_passe = $data['mot_de_passe'] ?? null;
        $this->adresse = $data['adresse'] ?? null;
        $this->telephone = $data['telephone'] ?? null;
        $this->date_de_naissance = $data['date_de_naissance'] ?? null;
        $this->langues = $data['langues'] ?? null;
        $this->nationalite = $data['nationalite'] ?? null;
        $this->date_d_inscription = $data['date_d_inscription'] ?? null;
        $this->statut = $data['statut'] ?? null;
        $this->situation = $data['situation'] ?? null;
        $this->besoins_specifiques = $data['besoins_specifiques'] ?? null;
        $this->photo_profil = $data['photo_profil'] ?? null;
        $this->date_derniere_connexion = $data['date_derniere_connexion'] ?? null;
        $this->statut_connexion = $data['statut_connexion'] ?? null;
        $this->emploi = $data['emploi'] ?? null;
        $this->societe = $data['societe'] ?? null;
        $this->code_verification = $data['code_verification'] ?? null;
        $this->type_permis = $data['type_permis'] ?? null;

        $this->validate($data);
    }

    public function validate($data) {
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Adresse email invalide.");
        }
        // if (empty($data['mot_de_passe']) || strlen($data['mot_de_passe']) < 7) {
        //     throw new Exception("Le mot de passe est obligatoire et doit contenir au moins 7 caractères.");
        // }
    }

    public function hashPassword() {
        if (!empty($this->mot_de_passe)) {
            $this->mot_de_passe = password_hash($this->mot_de_passe, PASSWORD_DEFAULT);
        }
    }

    public function generateVerificationCode() {
        $this->code_verification = bin2hex(random_bytes(16));
    }

   
}

?>
