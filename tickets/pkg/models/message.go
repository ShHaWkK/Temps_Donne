package models

import "time"

// Message représente un message dans votre système de chat.
type Message struct {
	ID         int64
	SenderID   int64 // Référence à User
	ReceiverID int64 // Référence à User
	Text       string
	Timestamp  time.Time
	Read       bool
}
