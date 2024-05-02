package web

import (
	"TicketingSystem/src/const"
	"TicketingSystem/src/manager"
	"net/http"
	"strconv"
)

func EnableHandlers() {
	// Serve static files like CSS and JS
	staticDir := http.Dir("html/src")
	staticHandler := http.FileServer(staticDir)
	http.Handle("/static/", http.StripPrefix("/static/", staticHandler))

	// Set up route handlers
	http.HandleFunc(_const.RouteIndex, IndexHandler)
	http.HandleFunc(_const.RouteListTickets, RetrieveTicketsHandler)

	// Logging the setup
	manager.Log.Infos("Handlers enabled, starting server on port " + _const.PORT)

	// Start the HTTP server
	if err := http.ListenAndServe(":"+_const.PORT, nil); err != nil {
		manager.Log.Error("Failed to start server: ", err)
		return
	}
	manager.Log.Infos("Server stopped on port " + _const.PORT)
}

func IndexHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodGet {
		http.Redirect(w, r, _const.RouteIndex, http.StatusSeeOther)
		return
	}
	manager.Templates.ExecuteTemplate(w, "menu.html", nil)
}

func RetrieveTicketsHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodGet {
		http.Redirect(w, r, _const.RouteIndex, http.StatusSeeOther)
		return
	}

	idTicketStr := r.URL.Query().Get("idTicket")
	if idTicketStr == "" {
		tickets := manager.RetrieveTickets(nil)
		manager.Templates.ExecuteTemplate(w, "listTickets.html", map[string]interface{}{
			"tickets": tickets,
		})
		return
	}

	idTicket, err := strconv.Atoi(idTicketStr)
	if err != nil {
		http.Error(w, "Ticket ID must be an integer", http.StatusBadRequest)
		return
	}

	ticket := manager.RetrieveTickets(&idTicket)
	manager.Templates.ExecuteTemplate(w, "oneTicket.html", map[string]interface{}{
		"ticket": ticket,
	})
}
