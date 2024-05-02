package _const

import (
	"TicketingSystem/src/log"
)

// Constantes pour les strings
const (
	NullString = ""
	NullInt    = 0
)

// Constantes pour les tables SQL
const (
	TICKETS       = "Tickets"
	CHAT_MESSAGES = "ChatMessages"
	UTILISATEURS  = "Utilisateurs"
)

// Instanciation d'une variable Log pour éviter de la faire dans les autres fichiers.
var Log = log.NewLogHelper()
