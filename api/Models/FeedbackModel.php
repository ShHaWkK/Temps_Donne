<?php

class FeedbackModel {
    public $id_feedback;
    public $id_utilisateur;
    public $type;
    public $id_reference;
    public $commentaire;
    public $date_creation;

    public function __construct($data) {
        $this->id_feedback = $data['ID_Feedback'] ?? null;
        $this->id_utilisateur = $data['ID_Utilisateur'];
        $this->type = $data['Type'];
        $this->id_reference = $data['ID_Reference'];
        $this->commentaire = $data['Commentaire'];
        $this->date_creation = $data['Date_Creation'] ?? date('Y-m-d');
    }

    public function validate() {
        if (empty($this->id_utilisateur) || empty($this->type) || empty($this->id_reference) || empty($this->commentaire)) {
            throw new Exception("Tous les champs sont obligatoires.", 400);
        }

        if (!in_array($this->type, ['Service', 'Evenement', 'Formation'])) {
            throw new Exception("Type invalide. Les types acceptés sont 'Service', 'Evenement', 'Formation'.", 400);
        }

        if (strlen($this->commentaire) > 1000) {
            throw new Exception("Le commentaire ne doit pas dépasser 1000 caractères.", 400);
        }
    }
}
