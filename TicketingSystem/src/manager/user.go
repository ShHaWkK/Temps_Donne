package manager

import (
	"TicketingSystem/src/security"
	"database/sql"
)

func RegisterUser(db *sql.DB, email, password string) error {
	// Hasher le mot de passe
	Password, err := security.HashPassword(password)
	if err != nil {
		return err
	}

	// Insérer le nouvel utilisateur dans la base de données
	_, err = db.Exec("INSERT INTO Utilisateurs (Email, Mot_de_passe) VALUES (?, ?)", email, Password)
	return err
}
