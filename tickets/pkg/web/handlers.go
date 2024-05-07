package web

import (
	"html/template"
	"net/http"
	"strconv"
	"tickets/pkg/BDD"
)

// templates est un parseur de templates qui précharge les templates HTML pour éviter de les charger à chaque requête.
var templates = template.Must(template.ParseGlob("templates/*.html"))

// SetupRoutes configure les routes et les handlers correspondants.
func SetupRoutes() {
	http.HandleFunc("/login", loginHandler)
	http.HandleFunc("/logout", logoutHandler)
	http.HandleFunc("/admin/dashboard", adminDashboardHandler)
	http.HandleFunc("/volunteer/dashboard", volunteerDashboardHandler)
	http.HandleFunc("/beneficiary/dashboard", beneficiaryDashboardHandler)
	http.HandleFunc("/ticket/create", createTicketHandler)
	http.HandleFunc("/ticket/update", updateTicketHandler)
	http.HandleFunc("/chat", chatHandler)
	// Ajouter d'autres routes ici
}

// loginHandler gère la connexion des utilisateurs.
func loginHandler(w http.ResponseWriter, r *http.Request) {
	switch r.Method {
	case "GET":
		templates.ExecuteTemplate(w, "login.html", nil)
	case "POST":
		r.ParseForm()
		email := r.FormValue("email")
		password := r.FormValue("password")
		user, err := BDD.VerifyUser(email, password)
		if err != nil {
			http.Error(w, "Invalid credentials", http.StatusUnauthorized)
			return
		}
		// Ici, ajouter la gestion des sessions ou des cookies
		http.Redirect(w, r, "/"+user.Role+"/dashboard", http.StatusSeeOther)
	default:
		http.Error(w, "Unsupported method", http.StatusMethodNotAllowed)
	}
}

// logoutHandler permet à un utilisateur de se déconnecter.
func logoutHandler(w http.ResponseWriter, r *http.Request) {
	// Ici, effacer les données de session ou les cookies
	http.Redirect(w, r, "/login", http.StatusSeeOther)
}

// adminDashboardHandler affiche le tableau de bord de l'administrateur.
func adminDashboardHandler(w http.ResponseWriter, r *http.Request) {
	// Vérifier les permissions, puis
	templates.ExecuteTemplate(w, "admin_dashboard.html", nil)
}

// volunteerDashboardHandler affiche le tableau de bord du bénévole.
func volunteerDashboardHandler(w http.ResponseWriter, r *http.Request) {
	// Vérifier les permissions, puis
	templates.ExecuteTemplate(w, "volunteer_dashboard.html", nil)
}

// beneficiaryDashboardHandler affiche le tableau de bord du bénéficiaire.
func beneficiaryDashboardHandler(w http.ResponseWriter, r *http.Request) {
	// Vérifier les permissions, puis
	templates.ExecuteTemplate(w, "beneficiary_dashboard.html", nil)
}

// createTicketHandler gère la création de tickets.
func createTicketHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method == "POST" {
		r.ParseForm()
		title := r.FormValue("title")
		description := r.FormValue("description")
		// Supposer que userID vient de la session ou des cookies
		userID := 1 // Cette valeur devrait être récupérée de manière sécurisée
		if err := BDD.CreateTicket(title, description, userID); err != nil {
			http.Error(w, "Failed to create ticket", http.StatusInternalServerError)
			return
		}
		http.Redirect(w, r, "/dashboard", http.StatusSeeOther)
	} else {
		http.Error(w, "Invalid request method", http.StatusMethodNotAllowed)
	}
}

// updateTicketHandler gère la mise à jour des tickets.
func updateTicketHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method == "POST" {
		r.ParseForm()
		ticketID, _ := strconv.Atoi(r.FormValue("ticketID"))
		newStatus := r.FormValue("status")
		if err := BDD.UpdateTicketStatus(ticketID, newStatus); err != nil {
			http.Error(w, "Failed to update ticket", http.StatusInternalServerError)
			return
		}
		http.Redirect(w, r, "/dashboard", http.StatusSeeOther)
	} else {
		http.Error(w, "Invalid request method", http.StatusMethodNotAllowed)
	}
}

// chatHandler gère la messagerie entre utilisateurs.
func chatHandler(w http.ResponseWriter, r *http.Request) {
	// Implémenter la logique de messagerie ici
	templates.ExecuteTemplate(w, "chat.html", nil)
}
