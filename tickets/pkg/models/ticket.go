package models

import "time"

// Ticket représente un ticket dans votre système.
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
