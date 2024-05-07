package models

// DashboardStats représente les statistiques pour un tableau de bord utilisateur.
type DashboardStats struct {
	TicketsByStatus map[string]int
}
