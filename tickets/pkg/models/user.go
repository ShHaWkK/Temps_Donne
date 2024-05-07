package models

import "time"

// User représente un utilisateur dans votre système.
type User struct {
	ID                 int64
	Nom                string
	Prenom             string
	Gender             string // 'Homme', 'Femme', 'Autre'
	Email              string
	Password           string // Stocké sous forme hashée
	Role               string // 'Benevole', 'Beneficiaire', 'Administrateur'
	Address            string
	Phone              string
	BirthDate          time.Time
	Languages          string
	Nationality        string
	RegistrationDate   time.Time
	Situation          string
	SpecialNeeds       string
	ProfilePicture     string
	LastLoginDate      time.Time
	IsConnected        bool
	Job                string
	Company            string
	VerificationCode   string
	DrivingLicenseType string
	Status             string // 'Pending', 'Granted', 'Denied'
}
