package log

import (
	"log"
	"os"
)

type LogHelper struct {
	Info  *log.Logger
	Error *log.Logger
}

func NewLogHelper() *LogHelper {
	file, err := os.OpenFile("app.log", os.O_CREATE|os.O_APPEND|os.O_WRONLY, 0666)
	if err != nil {
		log.Fatalf("Failed to open log file: %v", err)
	}
	return &LogHelper{
		Info:  log.New(file, "INFO: ", log.Ldate|log.Ltime|log.Lshortfile),
		Error: log.New(file, "ERROR: ", log.Ldate|log.Ltime|log.Lshortfile),
	}
}
