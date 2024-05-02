package main

import (
	"TicketingSystem/src/log"
	"TicketingSystem/src/web"
	"os"
	"os/signal"
	"syscall"
)

func main() {
	logger := log.NewLogHelper()
	logger.Info.Println("Starting Ticketing System...")

	err := web.LoadTemplates("html/templates")
	if err != nil {
		logger.Error.Fatalf("Failed to load templates: %v", err)
	}

	web.SetupRoutes()

	go func() {
		logger.Info.Println("Server starting on port 8085...")
		if err := web.StartServer("8085"); err != nil {
			logger.Error.Fatalf("Server failed to start: %v", err)
		}
	}()

	// Waiting for interrupt signal to gracefully shut down the server
	quit := make(chan os.Signal, 1)
	signal.Notify(quit, syscall.SIGINT, syscall.SIGTERM)
	<-quit

	logger.Info.Println("Shutting down server...")
}
