<?php

require_once 'BDD.php';
require_once './Models/FeedbackModel.php';

class FeedbackRepository {
    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    public function findAll() {
        $sql = "SELECT * FROM Feedbacks";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $sql = "SELECT * FROM Feedbacks WHERE ID_Feedback = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($feedback) {
        $sql = is_null($feedback['id_feedback']) ?
            "INSERT INTO Feedbacks (ID_Utilisateur, Type, ID_Reference, Commentaire, Date_Creation) VALUES (:id_utilisateur, :type, :id_reference, :commentaire, :date_creation)" :
            "UPDATE Feedbacks SET ID_Utilisateur = :id_utilisateur, Type = :type, ID_Reference = :id_reference, Commentaire = :commentaire, Date_Creation = :date_creation WHERE ID_Feedback = :id_feedback";
        $stmt = $this->db->prepare($sql);
        if (!is_null($feedback['id_feedback'])) {
            $stmt->bindValue(':id_feedback', $feedback['id_feedback'], PDO::PARAM_INT);
        }
        $stmt->bindValue(':id_utilisateur', $feedback['id_utilisateur'], PDO::PARAM_INT);
        $stmt->bindValue(':type', $feedback['type']);
        $stmt->bindValue(':id_reference', $feedback['id_reference'], PDO::PARAM_INT);
        $stmt->bindValue(':commentaire', $feedback['commentaire']);
        $stmt->bindValue(':date_creation', $feedback['date_creation']);
        $stmt->execute();
        return $feedback['id_feedback'] ? $feedback['id_feedback'] : $this->db->lastInsertId();
    }

    public function delete($id) {
        $sql = "DELETE FROM Feedbacks WHERE ID_Feedback = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
