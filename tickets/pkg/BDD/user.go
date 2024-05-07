package BDD

import (
	"database/sql"
	"golang.org/x/crypto/bcrypt"
	"tickets/pkg/models"
)

func VerifyUser(email, password string) (*models.User, error) {
	user := &models.User{}
	var hashedPassword string
	err := DB.QueryRow("SELECT ID_Utilisateur, Email, Role, Mot_de_Passe FROM Utilisateurs WHERE Email = ?", email).Scan(&user.ID, &user.Email, &user.Role, &hashedPassword)
	if err != nil {
		return nil, err
	}
	err = bcrypt.CompareHashAndPassword([]byte(hashedPassword), []byte(password))
	if err != nil {
		return nil, err
	}
	return user, nil
}

/*
* GetUserEmail
 */
func GetUserByEmail(email string) (*models.User, error) {
	var user models.User
	query := "SELECT ID_Utilisateur, Email, Role, Nom, Prenom FROM Utilisateurs WHERE Email = ?"
	err := DB.QueryRow(query, email).Scan(&user.ID, &user.Email, &user.Role, &user.Nom, &user.Prenom)
	if err != nil {
		if err == sql.ErrNoRows {
			return nil, nil
		}
		return nil, err
	}
	return &user, nil
}
