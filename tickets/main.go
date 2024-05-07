package tickets

import (
	"net/http"
	"tickets/pkg/web"
)

func main() {
	web.SetupRoutes() // Set up all the routes
	http.ListenAndServe(":8080", nil)
}
