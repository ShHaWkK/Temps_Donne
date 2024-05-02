package models

import "time"

type Message struct {
	ID             int
	IDExpediteur   int
	IDDestinataire int
	Texte          string
	Timestamp      time.Time
	Lu             bool
}