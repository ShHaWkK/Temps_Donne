package ticket

// Ticket représente la structure d'un ticket dans la base de données.
type Ticket struct {
    ID          int
    Titre       string
    Description string
    Statut      string
}
