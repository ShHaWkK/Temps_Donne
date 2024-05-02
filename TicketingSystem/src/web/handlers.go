package web

import (
	"TicketingSystem/src/BDD"
	"TicketingSystem/src/log"
	"TicketingSystem/src/manager"
	"net/http"
)

func SetupRoutes() {
	http.HandleFunc("/", homeHandler)
	http.HandleFunc("/tickets", ticketsHandler)
	http.HandleFunc("/tickets/add", addTicketHandler)
	// Define more routes as needed
}

func homeHandler(w http.ResponseWriter, r *http.Request) {
	RenderTemplate(w, "index", nil)
}

func ticketsHandler(w http.ResponseWriter, r *http.Request) {
	db, err := BDD.OpenDB()
	if err != nil {
		log.NewLogHelper().Error.Println("Failed to connect to database:", err)
		http.Error(w, "Internal Server Error", 500)
		return
	}
	defer db.Close()

	tickets, err := manager.GetAllTickets(db)
	if err != nil {
		log.NewLogHelper().Error.Println("Failed to retrieve tickets:", err)
		http.Error(w, "Internal Server Error", 500)
		return
	}
	RenderTemplate(w, "tickets", tickets)
}

func addTicketHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method == http.MethodGet {
		RenderTemplate(w, "add_ticket", nil)
	} else if r.Method == http.MethodPost {
		err := r.ParseForm()
		if err != nil {
			http.Error(w, "Failed to parse form", http.StatusBadRequest)
			return
		}
		titre := r.FormValue("titre")
		description := r.FormValue("description")
		db, err := BDD.OpenDB()
		if err != nil {
			log.NewLogHelper().Error.Println("Failed to connect to database:", err)
			http.Error(w, "Internal Server Error", 500)
			return
		}
		defer db.Close()
		_, err = manager.CreateTicket(db, titre, description, 1) // Assume user ID 1 for now
		if err != nil {
			log.NewLogHelper().Error.Println("Failed to create ticket:", err)
			http.Error(w, "Internal Server Error", 500)
			return
		}
		http.Redirect(w, r, "/tickets", http.StatusSeeOther)
	} else {
		http.Error(w, "Method Not Allowed", http.StatusMethodNotAllowed)
	}
}

// Implement other handlers similarly
