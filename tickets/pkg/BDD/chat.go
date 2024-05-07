package BDD

import "time"

type Message struct {
	ID         int64
	SenderID   int64 // Référence à User
	ReceiverID int64 // Référence à User
	Text       string
	Timestamp  time.Time
	Read       bool
}

// SendMessage enregistre un message envoyé dans la base de données.
func SendMessage(senderID, receiverID int, message string) error {
	_, err := DB.Exec("INSERT INTO ChatMessages (ID_Expediteur_Utilisateur, ID_Destinataire_Utilisateur, Message) VALUES (?, ?, ?)",
		senderID, receiverID, message)
	return err
}

// GetMessages récupère les messages entre deux utilisateurs.
func GetMessages(senderID, receiverID int) ([]Message, error) {
	rows, err := DB.Query("SELECT Message, Timestamp FROM ChatMessages WHERE ID_Expediteur_Utilisateur = ? AND ID_Destinataire_Utilisateur = ? ORDER BY Timestamp DESC",
		senderID, receiverID)
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	var messages []Message
	for rows.Next() {
		var msg Message
		if err := rows.Scan(&msg.Text, &msg.Timestamp); err != nil {
			return nil, err
		}
		messages = append(messages, msg)
	}

	return messages, nil
}
