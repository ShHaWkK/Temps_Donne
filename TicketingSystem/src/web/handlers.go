package web

import (
	"TicketingSystem/src/BDD"
	"TicketingSystem/src/log"
	"TicketingSystem/src/manager"
	"TicketingSystem/src/models"
	"TicketingSystem/src/security"
	"database/sql"

	"github.com/gorilla/sessions"

	"net/http"
	"strconv"
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

// Store for session data
var store = sessions.NewCookieStore([]byte("niSJbPBq/HDWlivEJGaUHvVa9ccljczilsVqmTj65R0="))

func GetUserByEmail(db *sql.DB, email string) (*models.Utilisateur, error) {
	var user models.Utilisateur
	err := db.QueryRow("SELECT ID, Email, Mot_de_passe, Role FROM Utilisateurs WHERE Email = ?", email).Scan(&user.ID, &user.Email, &user.Mot_de_passe, &user.Role)
	if err != nil {
		return nil, err
	}
	return &user, nil
}

func LoginHandler(db *sql.DB, w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodPost {
		http.Error(w, "Method Not Allowed", http.StatusMethodNotAllowed)
		return
	}

	err := r.ParseForm()
	if err != nil {
		http.Error(w, "Invalid form data", http.StatusBadRequest)
		return
	}

	email := r.FormValue("email")
	password := r.FormValue("password")

	user, err := GetUserByEmail(db, email)
	if err != nil {
		http.Error(w, "User not found", http.StatusNotFound)
		return
	}

	if !security.CheckPasswordHash(password, user.Mot_de_passe) {
		http.Error(w, "Invalid password", http.StatusUnauthorized)
		return
	}

	// Création de la session
	session, err := store.Get(r, "session-name")
	if err != nil {
		http.Error(w, "Session error", http.StatusInternalServerError)
		return
	}
	session.Values["authenticated"] = true
	session.Values["user_id"] = user.ID
	session.Values["role"] = user.Role
	err = session.Save(r, w)
	if err != nil {
		http.Error(w, "Failed to save session", http.StatusInternalServerError)
		return
	}

	// Rediriger en fonction du rôle
	redirectPath := "/user"
	if user.Role == "Administrateur" {
		redirectPath = "/admin"
	}
	http.Redirect(w, r, redirectPath, http.StatusSeeOther)
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

// View a specific ticket
func viewTicketHandler(w http.ResponseWriter, r *http.Request) {
	idStr := r.URL.Query().Get("id")
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "Invalid Ticket ID", http.StatusBadRequest)
		return
	}
	db, err := BDD.OpenDB()
	if err != nil {
		log.NewLogHelper().Error.Println("Failed to connect to database:", err)
		http.Error(w, "Internal Server Error", 500)
		return
	}
	defer db.Close()
	ticket, err := manager.GetTicket(db, id)
	if err != nil {
		log.NewLogHelper().Error.Println("Failed to retrieve ticket:", err)
		http.Error(w, "Internal Server Error", 500)
		return
	}
	RenderTemplate(w, "view_ticket", ticket)
}

// Edit a specific ticket
func editTicketHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method == "GET" {
		// Similar to viewTicketHandler, but load edit_ticket.html
	} else if r.Method == "POST" {
		// Process form data and update the ticket in the database
	}
}

// Delete a specific ticket
func deleteTicketHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodPost {
		http.Error(w, "Method Not Allowed", http.StatusMethodNotAllowed)
		return
	}

	idStr := r.URL.Query().Get("id")
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "Invalid Ticket ID", http.StatusBadRequest)
		return
	}

	db, err := BDD.OpenDB()
	if err != nil {
		log.NewLogHelper().Error.Println("Failed to connect to database:", err)
		http.Error(w, "Internal Server Error", 500)
		return
	}
	defer db.Close()

	err = manager.DeleteTicket(db, id)
	if err != nil {
		log.NewLogHelper().Error.Println("Failed to delete ticket:", err)
		http.Error(w, "Internal Server Error", 500)
		return
	}

	http.Redirect(w, r, "/tickets", http.StatusSeeOther)
}

// Implement other handlers similarly
