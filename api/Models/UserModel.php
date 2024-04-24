<?php

class UserModel {
    public $id_utilisateur;
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
    public $role;

    public $apikey;

    public function __construct($data = []) {
        $this->id_utilisateur = $data['ID_Utilisateur'] ?? null;
        $this->nom = $data['Nom'] ?? null;
        $this->prenom = $data['Prenom'] ?? null;
        $this->email = $data['Email'] ?? null;
        $this->mot_de_passe = $data['Mot_de_passe'] ?? null;
        $this->adresse = $data['Adresse'] ?? null;
        $this->telephone = $data['Telephone'] ?? null;
        $this->date_de_naissance = $data['Date_de_naissance'] ?? null;
        $this->langues = $data['Langues'] ?? null;
        $this->nationalite = $data['Nationalite'] ?? null;
        $this->date_d_inscription = $data['Date_d_inscription'] ?? null;
        $this->statut = $data['Statut'] ?? null;
        $this->situation = $data['Situation'] ?? null;
        $this->besoins_specifiques = $data['Besoins_specifiques'] ?? null;
        $this->photo_profil = $data['Photo_Profil'] ?? null;
        $this->date_derniere_connexion = $data['Date_Derniere_Connexion'] ?? null;
        $this->statut_connexion = $data['Statut_connexion'] ?? null;
        $this->emploi = $data['Emploi'] ?? null;
        $this->societe = $data['Societe'] ?? null;
        $this->code_verification = $data['Code_Verification'] ?? null;
        $this->type_permis = $data['Type_Permis'] ?? null;
        $this->role = $data['Role'] ?? null;
        $this->apikey = $data['apikey'] ?? null;

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
            $this->mot_de_passe = hash("sha256", $this->mot_de_passe);
        }
    }

    public function generateVerificationCode() {
        $this->code_verification = bin2hex(random_bytes(16));
    }

    public function setStatut($statut) {
        $validStatuses = ['Pending', 'Granted', 'Denied'];
        if (!in_array($statut, $validStatuses)) {
            throw new Exception("Statut invalide. Les valeurs autorisées sont : 'En attente', 'Accordé', 'Refusé'.");
        }
        $this->statut = $statut;
    }

}

?>
