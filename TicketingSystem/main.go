package main

import (
	"TicketingSystem/src/log"
	"TicketingSystem/src/web"
	"os"
	"os/signal"
	"syscall"
)

func main() {
	logHelper := log.NewLogHelper()
	logHelper.Info.Println("Starting Ticketing System application...")

	// Configuration of the server routes
	web.SetupRoutes()

	go func() {
		if err := web.StartServer(); err != nil {
			logHelper.Error.Fatalf("Failed to start server: %v", err)
		}
	}()

	setupGracefulShutdown(logHelper)
}

func setupGracefulShutdown(logHelper *log.LogHelper) {
	sigChan := make(chan os.Signal, 1)
	signal.Notify(sigChan, syscall.SIGINT, syscall.SIGTERM)
	sig := <-sigChan
	logHelper.Info.Printf("Received %s signal, shutting down server...", sig)
}
