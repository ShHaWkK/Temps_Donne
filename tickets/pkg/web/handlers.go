package web

import (
	"html/template"
	"net/http"
	"strconv"
	"tickets/pkg/BDD"
	"time"
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

/*
*	SetSession établit une session pour un utilisateur authentifié.
 */

func SetSession(email string, w http.ResponseWriter) {
	expiration := time.Now().Add(1 * time.Hour)
	cookie := http.Cookie{Name: "session", Value: email, Expires: expiration, HttpOnly: true}
	http.SetCookie(w, &cookie)
}

/*
*	ClearSession supprime la session de l'utilisateur.
 */

func ClearSession(w http.ResponseWriter) {
	cookie := http.Cookie{Name: "session", Value: "", Expires: time.Now().Add(-1 * time.Hour), HttpOnly: true}
	http.SetCookie(w, &cookie)
}

/*
*	GetSession tente de récupérer et de vérifier la session d'un utilisateur.
 */
func GetSession(r *http.Request) (string, error) {
	cookie, err := r.Cookie("session")
	if err != nil {
		return "", err
	}
	return cookie.Value, nil
}

// logoutHandler permet à un utilisateur de se déconnecter.
func logoutHandler(w http.ResponseWriter, r *http.Request) {
	// Ici, effacer les données de session ou les cookies
	http.Redirect(w, r, "/login", http.StatusSeeOther)
}

// adminDashboardHandler vérifie si l'utilisateur est un administrateur avant d'afficher le dashboard.
func adminDashboardHandler(w http.ResponseWriter, r *http.Request) {
	email, err := GetSession(r)
	if err != nil {
		http.Redirect(w, r, "/login", http.StatusSeeOther)
		return
	}

	user, err := BDD.GetUserByEmail(email)
	if err != nil || user.Role != "Administrateur" {
		http.Error(w, "Access denied", http.StatusForbidden)
		return
	}

	templates.ExecuteTemplate(w, "admin_dashboard.html", user)
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

// chatHandler gère la récupération et l'envoi de messages.
func chatHandler(w http.ResponseWriter, r *http.Request) {
	switch r.Method {
	case "GET":
		userIDStr, err := GetSession(r)
		if err != nil {
			http.Redirect(w, r, "/login", http.StatusSeeOther)
			return
		}
		userID, err := strconv.Atoi(userIDStr)
		if err != nil {
			http.Error(w, "Invalid user ID", http.StatusBadRequest)
			return
		}
		messages, err := BDD.GetMessages(userID) // Assuming GetMessages needs only one userID to fetch conversations
		if err != nil {
			http.Error(w, "Unable to fetch messages", http.StatusInternalServerError)
			return
		}
		templates.ExecuteTemplate(w, "chat.html", messages)

	case "POST":
		receiverIDStr := r.FormValue("receiver_id")
		message := r.FormValue("message")
		senderIDStr, _ := GetSession(r)

		senderID, err := strconv.Atoi(senderIDStr)
		if err != nil {
			http.Error(w, "Invalid sender ID", http.StatusBadRequest)
			return
		}
		receiverID, err := strconv.Atoi(receiverIDStr)
		if err != nil {
			http.Error(w, "Invalid receiver ID", http.StatusBadRequest)
			return
		}

		if err := BDD.SendMessage(senderID, receiverID, message); err != nil {
			http.Error(w, "Failed to send message", http.StatusInternalServerError)
			return
		}
		http.Redirect(w, r, "/chat", http.StatusSeeOther)

	default:
		http.Error(w, "Unsupported method", http.StatusMethodNotAllowed)
	}
}
