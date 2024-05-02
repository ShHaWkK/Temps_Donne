package manager

import (
	"TicketingSystem/src/models"
	"database/sql"
	"time"
)

// CreateTicket inserts a new ticket into the database and returns the newly created ticket ID
func CreateTicket(db *sql.DB, titre, description string, idUtilisateur int) (int, error) {
	query := `INSERT INTO Tickets (Titre, Description, Date_Creation, Statut, Priorite, ID_Utilisateur, Date_Modification, ID_Modificateur) 
              VALUES (?, ?, ?, 'Ouvert', 'Moyen', ?, ?, ?)`
	now := time.Now()
	res, err := db.Exec(query, titre, description, now, idUtilisateur, now, idUtilisateur)
	if err != nil {
		return 0, err
	}
	id, err := res.LastInsertId()
	if err != nil {
		return 0, err
	}
	return int(id), nil
}

// GetTicket retrieves a ticket by its ID from the database
func GetTicket(db *sql.DB, id int) (*models.Ticket, error) {
	var ticket models.Ticket
	query := `SELECT ID, Titre, Description, DateCreation, Statut, Priorite, IDUtilisateur, IDAssignee, DateModification, IDModificateur 
              FROM Tickets WHERE ID = ?`
	err := db.QueryRow(query, id).Scan(&ticket.ID, &ticket.Titre, &ticket.Description, &ticket.DateCreation, &ticket.Statut, &ticket.Priorite, &ticket.IDUtilisateur, &ticket.IDAssignee, &ticket.DateModification, &ticket.IDModificateur)
	if err != nil {
		return nil, err
	}
	return &ticket, nil
}

// UpdateTicket modifies details of an existing ticket
func UpdateTicket(db *sql.DB, id int, titre, description, statut, priorite string, idAssignee, idModificateur int) error {
	query := `UPDATE Tickets SET Titre = ?, Description = ?, Statut = ?, Priorite = ?, ID_Assignee = ?, Date_Modification = ?, ID_Modificateur = ?
              WHERE ID = ?`
	now := time.Now()
	_, err := db.Exec(query, titre, description, statut, priorite, idAssignee, now, idModificateur, id)
	return err
}

func DeleteTicket(db *sql.DB, id int) error {
	query := "DELETE FROM Tickets WHERE ID = ?"
	_, err := db.Exec(query, id)
	return err
}

// AddMessage creates a new chat message in the database
func AddMessage(db *sql.DB, idExpediteur, idDestinataire int, texte string) (int, error) {
	query := `INSERT INTO ChatMessages (ID_Expediteur_Utilisateur, ID_Destinataire_Utilisateur, Message, Timestamp) VALUES (?, ?, ?, ?)`
	now := time.Now()
	res, err := db.Exec(query, idExpediteur, idDestinataire, texte, now)
	if err != nil {
		return 0, err
	}
	id, err := res.LastInsertId()
	if err != nil {
		return 0, err
	}
	return int(id), nil
}

// GetMessages retrieves all messages between users
func GetMessages(db *sql.DB, idUtilisateur int) ([]models.Message, error) {
	var messages []models.Message
	query := `SELECT ID, IDExpediteur, IDDestinataire, Texte, Timestamp, Lu 
              FROM ChatMessages WHERE IDExpediteur = ? OR IDDestinataire = ? ORDER BY Timestamp ASC`
	rows, err := db.Query(query, idUtilisateur, idUtilisateur)
	if err != nil {
		return nil, err
	}
	defer rows.Close()
	for rows.Next() {
		var message models.Message
		if err := rows.Scan(&message.ID, &message.IDExpediteur, &message.IDDestinataire, &message.Texte, &message.Timestamp, &message.Lu); err != nil {
			return nil, err
		}
		messages = append(messages, message)
	}
	return messages, nil
}

// GetAllTickets retrieves all tickets from the database
func GetAllTickets(db *sql.DB) ([]models.Ticket, error) {
	var tickets []models.Ticket
	query := "SELECT ID, Titre, Description, DateCreation, Statut, Priorite, IDUtilisateur, IDAssignee, DateModification, IDModificateur FROM Tickets"
	rows, err := db.Query(query)
	if err != nil {
		return nil, err
	}
	defer rows.Close()
	for rows.Next() {
		var ticket models.Ticket
		if err := rows.Scan(&ticket.ID, &ticket.Titre, &ticket.Description, &ticket.DateCreation, &ticket.Statut, &ticket.Priorite, &ticket.IDUtilisateur, &ticket.IDAssignee, &ticket.DateModification, &ticket.IDModificateur); err != nil {
			return nil, err
		}
		tickets = append(tickets, ticket)
	}
	return tickets, nil
}
