package web

import (
	"TicketingSystem/src/BDD"
	"TicketingSystem/src/log"
	"TicketingSystem/src/manager"
	"html/template"
	"net/http"
)

var templates *template.Template

func init() {
	var err error
	templates, err = template.ParseGlob("html/templates/*.html")
	if err != nil {
		log.NewLogHelper().Error.Fatal("Error parsing templates: ", err)
	}
}

func SetupRoutes() {
	http.HandleFunc("/", IndexHandler)
	http.HandleFunc("/list", ListTicketsHandler)
	log.NewLogHelper().Info.Println("Starting server on port 8085")
	http.ListenAndServe(":8085", nil)
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

func RenderTemplate(w http.ResponseWriter, tmpl string, data interface{}) {
	if err := templates.ExecuteTemplate(w, tmpl+".html", data); err != nil {
		log.NewLogHelper().Error.Println("Template execution error: ", err)
		http.Error(w, "Error rendering page", http.StatusInternalServerError)
	}
}
