package BDD

import (
	"tickets/pkg/models"
)

// GetDashboardStats récupère les statistiques nécessaires pour le tableau de bord d'un utilisateur.
func GetDashboardStats(userID int) (models.DashboardStats, error) {
	var stats models.DashboardStats
	stats.TicketsByStatus = make(map[string]int) // Initialiser la map avant utilisation.

	// Requête pour compter les tickets par statut pour un utilisateur donné.
	query := `SELECT Statut, COUNT(*) FROM Tickets WHERE ID_Utilisateur = ? GROUP BY Statut`
	rows, err := DB.Query(query, userID)
	if err != nil {
		return stats, err
	}
	defer rows.Close()

	// Lire les résultats de la requête et les stocker dans la structure de statistiques.
	for rows.Next() {
		var count int
		var status string
		if err := rows.Scan(&status, &count); err != nil {
			return stats, err
		}
		stats.TicketsByStatus[status] = count
	}

	return stats, nil
}

// obtenir plus de détails, comme les tickets récents ou urgents.
func GetRecentTickets(userID int) ([]models.Ticket, error) {
	var tickets []models.Ticket
	query := `SELECT ID, Titre, Description, Statut, Date_Creation FROM Tickets WHERE ID_Utilisateur = ? ORDER BY Date_Creation DESC LIMIT 10`
	rows, err := DB.Query(query, userID)
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	for rows.Next() {
		var ticket models.Ticket
		if err := rows.Scan(&ticket.ID, &ticket.Title, &ticket.Description, &ticket.Status, &ticket.CreationDate); err != nil {
			return nil, err
		}
		tickets = append(tickets, ticket)
	}

	return tickets, nil
}
