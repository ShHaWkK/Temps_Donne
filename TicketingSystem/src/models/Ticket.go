package models

import "time"

type Ticket struct {
	ID               int
	Titre            string
	Description      string
	DateCreation     time.Time
	Statut           string
	Priorite         string
	IDUtilisateur    int
	IDAssignee       int
	DateModification time.Time
	IDModificateur   int
}
