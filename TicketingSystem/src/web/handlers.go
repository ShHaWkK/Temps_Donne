package web

import (
	"TicketingSystem/src/BDD"
	"TicketingSystem/src/log"
	"TicketingSystem/src/manager"
	"net/http"
)

const serverPort = "8085"

func init() {
	err := LoadTemplates("html/templates")
	if err != nil {
		log.NewLogHelper().Error.Fatal("Error parsing templates: ", err)
	}
}

func SetupRoutes() {
	http.HandleFunc("/", IndexHandler)
	http.HandleFunc("/list", ListTicketsHandler)
}

// StartServer starts the HTTP server on the defined port
func StartServer() error {
	log.NewLogHelper().Info.Println("Starting server on port " + serverPort)
	return http.ListenAndServe(":"+serverPort, nil)
}

func IndexHandler(w http.ResponseWriter, r *http.Request) {
	RenderTemplate(w, "index", nil)
}

func ListTicketsHandler(w http.ResponseWriter, r *http.Request) {
	db, err := BDD.OpenDB()
	if err != nil {
		log.NewLogHelper().Error.Println("Database connection error: ", err)
		http.Error(w, "Internal Server Error", http.StatusInternalServerError)
		return
	}
	defer db.Close()

	tickets, err := manager.RetrieveAllTickets(db)
	if err != nil {
		log.NewLogHelper().Error.Println("Failed to retrieve tickets: ", err)
		http.Error(w, "Internal Server Error", http.StatusInternalServerError)
		return
	}
	RenderTemplate(w, "listTickets", tickets)
}
