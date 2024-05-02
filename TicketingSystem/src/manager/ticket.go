package manager

import (
	. "TicketingSystem/src/models"
	"database/sql"
	_ "github.com/go-sql-driver/mysql"
	"time"
)

// Fonctions de gestion des tickets
func createTicket(db *sql.DB, titre, description string, idUtilisateur int) (int, error) {
	stmt, err := db.Prepare("INSERT INTO Tickets (Titre, Description, Date_Creation, Statut, Priorite, ID_Utilisateur, Date_Modification, ID_Modificateur) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
	if err != nil {
		return 0, err
	}
	defer stmt.Close()

	now := time.Now()
	_, err = stmt.Exec(titre, description, now, "Ouvert", "Moyen", idUtilisateur, now, idUtilisateur)
	if err != nil {
		return 0, err
	}

	var id int
	err = db.QueryRow("SELECT LAST_INSERT_ID()").Scan(&id)
	if err != nil {
		return 0, err
	}

	return id, nil
}

func getTicket(db *sql.DB, id int) (*Ticket, error) {
	stmt, err := db.Prepare("SELECT ID_Ticket, Titre, Description, Date_Creation, Statut, Priorite, ID_Utilisateur, ID_Assignee, Date_Modification, ID_Modificateur FROM Tickets WHERE ID_Ticket = ?")
	if err != nil {
		return nil, err
	}
	defer stmt.Close()

	var ticket Ticket
	err = stmt.QueryRow(id).Scan(&ticket.ID, &ticket.Titre, &ticket.Description, &ticket.DateCreation, &ticket.Statut, &ticket.Priorite, &ticket.IDUtilisateur, &ticket.IDAssignee, &ticket.DateModification, &ticket.IDModificateur)
	if err != nil {
		return nil, err
	}

	return &ticket, nil
}

func updateTicket(db *sql.DB, id int, titre, description, statut, priorite string, idAssignee, idModificateur int) error {
	stmt, err := db.Prepare("UPDATE Tickets SET Titre = ?, Description = ?, Statut = ?, Priorite = ?, ID_Assignee = ?, Date_Modification = ?, ID_Modificateur = ? WHERE ID_Ticket = ?")
	if err != nil {
		return err
	}
	defer stmt.Close()

	now := time.Now()
	_, err = stmt.Exec(titre, description, statut, priorite, idAssignee, now, idModificateur, id)
	if err != nil {
		return err
	}

	return nil
}

func addMessage(db *sql.DB, idExpediteur, idDestinataire int, texte string) (int, error) {
	stmt, err := db.Prepare("INSERT INTO ChatMessages (ID_Expediteur_Utilisateur, ID_Destinataire_Utilisateur, Message, Timestamp) VALUES (?, ?, ?, ?)")
	if err != nil {
		return 0, err
	}
	defer stmt.Close()

	now := time.Now()
	res, err := stmt.Exec(idExpediteur, idDestinataire, texte, now)
	if err != nil {
		return 0, err
	}

	id, err := res.LastInsertId()
	if err != nil {
		return 0, err
	}

	return int(id), nil
}

func getMessages(db *sql.DB, idUtilisateur int) ([]Message, error) {
	stmt, err := db.Prepare("SELECT ID_Message, ID_Expediteur_Utilisateur, ID_Destinataire_Utilisateur, Message, Timestamp, Lu FROM ChatMessages WHERE ID_Expediteur_Utilisateur = ? OR ID_Destinataire_Utilisateur = ? ORDER BY Timestamp ASC")
	if err != nil {
		return nil, err
	}
	defer stmt.Close()

	rows, err := stmt.Query(idUtilisateur, idUtilisateur)
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	var messages []Message
	for rows.Next() {
		var message Message
		err := rows.Scan(&message.ID, &message.IDExpediteur, &message.IDDestinataire, &message.Texte, &message.Timestamp, &message.Lu)
		if err != nil {
			return nil, err
		}
		messages = append(messages, message)
	}

	if err := rows.Err(); err != nil {
		return nil, err
	}

	return messages, nil
}

func RetrieveAllTickets(db *sql.DB) ([]Ticket, error) {
	var tickets []Ticket
	rows, err := db.Query("SELECT * FROM Tickets")
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	for rows.Next() {
		var t Ticket
		if err := rows.Scan(&t.ID, &t.Titre, &t.Description, &t.DateCreation, &t.Statut, &t.Priorite, &t.IDUtilisateur, &t.IDAssignee, &t.DateModification, &t.IDModificateur); err != nil {
			return nil, err
		}
		tickets = append(tickets, t)
	}
	return tickets, nil
}
