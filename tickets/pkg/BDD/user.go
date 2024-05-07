package BDD

import (
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
