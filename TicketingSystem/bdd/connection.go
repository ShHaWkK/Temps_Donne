package bdd

import (
    "database/sql"
    "log"

    _ "github.com/go-sql-driver/mysql" // Import du driver MySQL
)

var DB *sql.DB

// Initialize initie la connexion à la base de données.
func Initialize(dataSourceName string) {
    var err error
    DB, err = sql.Open("mysql", dataSourceName)
    if err != nil {
        log.Fatal(err)
    }

    if err = DB.Ping(); err != nil {
        log.Fatal(err)
    }

    log.Println("Connexion à la base de données réussie!")
}
