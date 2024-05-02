package BDD

import (
	. "TicketingSystem/src/models"
	"database/sql"
	"fmt"

	_ "github.com/go-sql-driver/mysql"
)

// Ouvre une nouvelle connexion à la base de données
func OpenDB() (*sql.DB, error) {
	dsn := "root:toor@tcp(db:3306)/temps"
	db, err := sql.Open("mysql", dsn)
	if err != nil {
		return nil, fmt.Errorf("OpenDB: %v", err)
	}
	if err := db.Ping(); err != nil {
		return nil, fmt.Errorf("OpenDB Ping: %v", err)
	}
	return db, nil
}

// CloseDB ferme la connexion à la base de données.
func CloseDB(db *sql.DB) error {
	return db.Close()
}
