package tickets

import (
	"net/http"
	"tickets/pkg/web"
)

func main() {
	web.SetupRoutes()
	http.ListenAndServe(":8080", nil)
}
