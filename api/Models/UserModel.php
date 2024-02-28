<?php

class UserModel {
    public $id_utilisateur;
    public $nom;
    public $prenom;
    public $email;
    public $mot_de_passe;
    public $role;
    public $adresse;
    public $telephone;
    public $date_de_naissance;
    public $langues;
    public $nationalite;
    public $date_d_inscription;
    public $statut;
    public $situation;
    public $besoins_specifiques;
    public $photo_profil;
    public $date_derniere_connexion;
    public $statut_connexion;
    public $emploi;
    public $societe;
    public $est_verifie;
    public $code_verification;
    public $type_permis;
    public $statut_benevole;

    public function __construct($data = []) {
        if (!empty($data)) {
            $this->id_utilisateur = $data['id_utilisateur'] ?? null;
            $this->nom = $data['nom'] ?? null;
            $this->prenom = $data['prenom'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->mot_de_passe = $data['mot_de_passe'] ?? null;
            $this->role = $data['role'] ?? null;
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
            $this->est_verifie = $data['est_verifie'] ?? false;
            $this->code_verification = $data['code_verification'] ?? null;
            $this->type_permis = $data['type_permis'] ?? null;
            // statut_bénévole Validé, En attente de validation, Refusé
            $this->statut_benevole = $data['statut_benevole'] ?? null;

            $this->validate($data); // corrected line
        }
    }

    //Ignore 
    // public function toJson() {
    //     return json_encode([
    //         'id_utilisateur' => $this->id_utilisateur,
    //         'nom' => $this->nom,
    //         'prenom' => $this->prenom,
    //         'email' => $this->email,
    //         'role' => $this->role,
    //         'adresse' => $this->adresse,
    //         'telephone' => $this->telephone,
    //         'date_de_naissance' => $this->date_de_naissance,
    //         'langues' => $this->langues,
    //         'nationalite' => $this->nationalite,
    //         'date_d_inscription' => $this->date_d_inscription,
    //         'statut' => $this->statut,
    //         'situation' => $this->situation,
    //         'besoins_specifiques' => $this->besoins_specifiques,
    //         'photo_profil' => $this->photo_profil,
    //         'date_derniere_connexion' => $this->date_derniere_connexion,
    //         'statut_connexion' => $this->statut_connexion,
    //         'emploi' => $this->emploi,
    //         'societe' => $this->societe,
    //         'est_verifie' => $this->est_verifie,
    //         'code_verification' => $this->code_verification,
    //         'type_permis' => $this->type_permis
    //     ]);
    // }
    // public static function fromJson($json) {
    //     $data = json_decode($json, true);
    //     return new self($data);
    // }


    public function validate($data) {
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Adresse email invalide.");
        }
        // if (empty($data['mot_de_passe']) || strlen($data['mot_de_passe']) < 8) {
        //     throw new Exception("Le mot de passe est obligatoire et doit contenir au moins 8 caractères.");
        // }
        if ($this->role === 'Benevole' && empty($data['statut_benevole'])) {
            throw new Exception("Le statut du bénévole est requis.");
        }
    }



    // Méthode pour hacher le mot de passe
    public function hashPassword() {
        if ($this->mot_de_passe !== null) {
            $this->mot_de_passe = password_hash($this->mot_de_passe, PASSWORD_DEFAULT);
        } else {
            throw new Exception("Password cannot be null.");
        }
    }
    // Méthode pour générer un code de vérification
    public function generateVerificationCode() {
        $this->code_verification = bin2hex(random_bytes(16));
    }


}

/*********************************************************** */
/*
*<?php

class UserModel {
    public $id_utilisateur;
    public $nom;
    public $prenom;
    public $email;
    public $mot_de_passe;
    public $role;
    public $adresse;
    public $telephone;
    public $date_de_naissance;
    public $langues;
    public $nationalite;
    public $date_d_inscription;
    public $statut;
    public $situation;
    public $besoins_specifiques;
    public $photo_profil;
    public $date_derniere_connexion;
    public $statut_connexion;
    public $emploi;
    public $societe;
    public $est_verifie;
    public $code_verification;
    public $type_permis;
    public $statut_benevole;

    public function __construct($data = []) {
        if (!empty($data)) {
            $this->id_utilisateur = $data['id_utilisateur'] ?? null;
            $this->nom = $data['nom'] ?? null;
            $this->prenom = $data['prenom'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->mot_de_passe = $data['mot_de_passe'] ?? null;
            $this->role = $data['role'] ?? null;
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
            $this->est_verifie = $data['est_verifie'] ?? false;
            $this->code_verification = $data['code_verification'] ?? null;
            $this->type_permis = $data['type_permis'] ?? null;
            // statut_bénévole Validé, En attente de validation, Refusé
            $this->statut_benevole = $data['statut_benevole'] ?? null;

            $this->validate($data); // corrected line
        }
    }

    //Ignore 
    // public function toJson() {
    //     return json_encode([
    //         'id_utilisateur' => $this->id_utilisateur,
    //         'nom' => $this->nom,
    //         'prenom' => $this->prenom,
    //         'email' => $this->email,
    //         'role' => $this->role,
    //         'adresse' => $this->adresse,
    //         'telephone' => $this->telephone,
    //         'date_de_naissance' => $this->date_de_naissance,
    //         'langues' => $this->langues,
    //         'nationalite' => $this->nationalite,
    //         'date_d_inscription' => $this->date_d_inscription,
    //         'statut' => $this->statut,
    //         'situation' => $this->situation,
    //         'besoins_specifiques' => $this->besoins_specifiques,
    //         'photo_profil' => $this->photo_profil,
    //         'date_derniere_connexion' => $this->date_derniere_connexion,
    //         'statut_connexion' => $this->statut_connexion,
    //         'emploi' => $this->emploi,
    //         'societe' => $this->societe,
    //         'est_verifie' => $this->est_verifie,
    //         'code_verification' => $this->code_verification,
    //         'type_permis' => $this->type_permis
    //     ]);
    // }
    // public static function fromJson($json) {
    //     $data = json_decode($json, true);
    //     return new self($data);
    // }


    public function validate($data) {
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Adresse email invalide.");
        }
        // if (empty($data['mot_de_passe']) || strlen($data['mot_de_passe']) < 8) {
        //     throw new Exception("Le mot de passe est obligatoire et doit contenir au moins 8 caractères.");
        // }
        if ($this->role === 'Benevole' && empty($data['statut_benevole'])) {
            throw new Exception("Le statut du bénévole est requis.");
        }
    }



    // Méthode pour hacher le mot de passe
    public function hashPassword() {
        if ($this->mot_de_passe !== null) {
            $this->mot_de_passe = password_hash($this->mot_de_passe, PASSWORD_DEFAULT);
        } else {
            throw new Exception("Password cannot be null.");
        }
    }
    // Méthode pour générer un code de vérification
    public function generateVerificationCode() {
        $this->code_verification = bin2hex(random_bytes(16));
    }


}
*/

