package web

import (
	"html/template"
	"net/http"
	"path/filepath"
)

var Templates *template.Template

// LoadTemplates charge et compile les fichiers templates situés dans le dossier spécifié
func LoadTemplates(templatesDir string) error {
	// Cela permet de charger tous les fichiers .html présents dans le dossier
	pattern := filepath.Join(templatesDir, "*.html")
	templates, err := template.ParseGlob(pattern)
	if err != nil {
		return err
	}

	// Assigne les templates compilés à la variable globale Templates
	Templates = templates
	return nil
}

// RenderTemplate est utilisé pour rendre un template spécifique avec des données
func RenderTemplate(w http.ResponseWriter, tmpl string, data interface{}) {
	err := Templates.ExecuteTemplate(w, tmpl+".html", data)
	if err != nil {
		http.Error(w, "Service unavailable", http.StatusInternalServerError)
		return
	}
}
