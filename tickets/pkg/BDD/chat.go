package BDD

import (
	"tickets/pkg/models"
	"time"
)

type Message struct {
	ID         int64
	SenderID   int64 // Référence à User
	ReceiverID int64 // Référence à User
	Text       string
	Timestamp  time.Time
	Read       bool
}

// GetMessages récupère les messages entre deux utilisateurs.
func GetMessages(userID int) ([]models.Message, error) {
	var messages []models.Message
	query := "SELECT ID_Message, ID_Expediteur_Utilisateur, ID_Destinataire_Utilisateur, Message, Timestamp, Lu FROM ChatMessages WHERE ID_Expediteur_Utilisateur = ? OR ID_Destinataire_Utilisateur = ?"
	rows, err := DB.Query(query, userID, userID)
	if err != nil {
		return nil, err
	}
	defer rows.Close()
	for rows.Next() {
		var msg models.Message
		if err := rows.Scan(&msg.ID, &msg.SenderID, &msg.ReceiverID, &msg.Text, &msg.Timestamp, &msg.Read); err != nil {
			return nil, err
		}
		messages = append(messages, msg)
	}
	return messages, nil
}

// SendMessage adds a new message to the database.
func SendMessage(senderID, receiverID int, message string) error {
	query := "INSERT INTO ChatMessages (ID_Expediteur_Utilisateur, ID_Destinataire_Utilisateur, Message, Lu) VALUES (?, ?, ?, FALSE)"
	_, err := DB.Exec(query, senderID, receiverID, message)
	return err
}
