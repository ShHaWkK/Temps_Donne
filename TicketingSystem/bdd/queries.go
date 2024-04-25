package bdd

import (
    "log"
)

// GetUserByCredentials vérifie les identifiants de l'utilisateur et retourne son ID et son rôle.
func GetUserByCredentials(email, password string) (int, string, error) {
    var id int
    var role string
    query := `SELECT ID_Utilisateur, Role FROM Utilisateurs WHERE Email = ? AND Mot_de_passe = ?`
    err := DB.QueryRow(query, email, password).Scan(&id, &role)
    if err != nil {
        return 0, "", err
    }
    return id, role, nil
}

// GetTicketsByStatus récupère les tickets selon leur statut.
func GetTicketsByStatus(status string) ([]Ticket, error) {
    rows, err := DB.Query("SELECT ID_Ticket, Titre, Description, Statut FROM Tickets WHERE Statut = ?", status)
    if err != nil {
        return nil, err
    }
    defer rows.Close()

    tickets := []Ticket{}
    for rows.Next() {
        var t Ticket
        if err := rows.Scan(&t.ID, &t.Titre, &t.Description, &t.Statut); err != nil {
            return nil, err
        }
        tickets = append(tickets, t)
    }
    if err = rows.Err(); err != nil {
        return nil, err
    }
    return tickets, nil
}

// UpdateTicketStatus met à jour le statut d'un ticket.
func UpdateTicketStatus(ticketID int, status string) error {
    _, err := DB.Exec("UPDATE Tickets SET Statut = ? WHERE ID_Ticket = ?", status, ticketID)
    return err
}
