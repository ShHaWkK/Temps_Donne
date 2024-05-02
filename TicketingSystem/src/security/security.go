package security

import (
	"golang.org/x/crypto/bcrypt"
)

// HashPassword prend un mot de passe en clair et retourne le hash bcrypt correspondant
func HashPassword(password string) (string, error) {
	bytes, err := bcrypt.GenerateFromPassword([]byte(password), bcrypt.DefaultCost)
	if err != nil {
		return "", err
	}
	return string(bytes), nil
}

// CheckPasswordHash compare le mot de passe en clair avec un hash pour vérifier si les mots de passe correspondent
func CheckPasswordHash(password, hash string) bool {
	err := bcrypt.CompareHashAndPassword([]byte(hash), []byte(password))
	return err == nil
}
