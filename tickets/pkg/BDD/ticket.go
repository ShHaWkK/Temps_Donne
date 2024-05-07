package BDD

import (
	_ "tickets/pkg/models"
	"time"
)

type Ticket struct {
	ID               int64
	Title            string
	Description      string
	CreationDate     time.Time
	Status           string // 'Ouvert', 'En cours', 'Fermé'
	Priority         string // 'Bas', 'Moyen', 'Haut'
	UserID           int64  // Référence à User
	AssigneeID       int64  // Référence à User
	ModificationDate time.Time
	ModifierID       int64 // Référence à User qui a modifié le ticket
}

// CreateTicket crée un nouveau ticket dans la base de données.
func CreateTicket(title, description string, userID int) error {
	_, err := DB.Exec("INSERT INTO Tickets (Titre, Description, Date_Creation, ID_Utilisateur, Statut) VALUES (?, ?, ?, ?, 'Ouvert')",
		title, description, time.Now(), userID)
	return err
}

// GetTickets récupère tous les tickets pour un utilisateur spécifique.
func GetTickets(userID int) ([]Ticket, error) {
	rows, err := DB.Query("SELECT ID_Ticket, Titre, Description, Statut FROM Tickets WHERE ID_Utilisateur = ?", userID)
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	var tickets []Ticket
	for rows.Next() {
		var t Ticket
		if err := rows.Scan(&t.ID, &t.Title, &t.Description, &t.Status); err != nil {
			return nil, err
		}
		tickets = append(tickets, t)
	}

	return tickets, nil
}

// UpdateTicketStatus met à jour le statut d'un ticket.
func UpdateTicketStatus(ticketID int, status string) error {
	_, err := DB.Exec("UPDATE Tickets SET Statut = ? WHERE ID_Ticket = ?", status, ticketID)
	return err
}
