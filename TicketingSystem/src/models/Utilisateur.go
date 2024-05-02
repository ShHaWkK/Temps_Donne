package models

type Utilisateur struct {
	ID           int
	Nom          string
	Prenom       string
	Email        string
	Mot_de_passe string
	Role         string
}
