<?php

class AdminModel {
    public $id_admin;
    public $nom;
    public $prenom;
    public $email;
    public $mot_de_passe;
    public $role_id; 
    // public $role;
    public $date_d_inscription;
    public $statut;

    public function __construct($data) {
        $this->id_admin = $data['id_admin'] ?? null;
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->email = $data['email'];
        $this->mot_de_passe = $data['mot_de_passe'];
        // $this->role = $data['role'] ?? NULL ;
        $this->role_id = $data['role_id'] ?? null;
        $this->date_d_inscription = $data['date_d_inscription'] ?? date('Y-m-d');
        $this->statut = $data['statut'] ?? true;

        $this->validate();
    }

    public function validate() {
        if (empty($this->nom) || empty($this->prenom) || empty($this->email) || empty($this->mot_de_passe)) {
            throw new Exception("Missing required fields", 400);
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format", 400);
        }
        if (strlen($this->mot_de_passe) < 8) {
            throw new Exception("Password must be at least 8 characters", 400);
        }
    }

    // Méthode pour hacher le mot de passe
    public function hashPassword() {
        if (!empty($this->mot_de_passe)) {
            $this->mot_de_passe = hash("sha256", $this->mot_de_passe);
        } else {
            throw new Exception("Password cannot be empty", 400);
        }
    }
}

?>
