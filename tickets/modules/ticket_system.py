# modules/ticket_system.py
import mysql.connector

class TicketSystem:
    def __init__(self, db_config):
        self.db_config = db_config
        self.cnx = None
        self.cursor = None
        self.connect()

    def connect(self):
        """Établir une connexion à la base de données."""
        try:
            if not self.cnx or not self.cnx.is_connected():
                self.cnx = mysql.connector.connect(**self.db_config)
                self.cursor = self.cnx.cursor(dictionary=True)
        except mysql.connector.Error as err:
            print(f"Erreur de connexion SQL : {err}")

    def close(self):
        """Fermer la connexion à la base de données."""
        if self.cnx and self.cnx.is_connected():
            self.cursor.close()
            self.cnx.close()

    def get_tickets_by_user(self, user_id):
        query = """
            SELECT t.ID_Ticket, t.Titre, t.Statut, t.ID_Assignee, a.ID_Utilisateur AS Admin_ID
            FROM Tickets t
            LEFT JOIN Utilisateurs a ON t.ID_Assignee = a.ID_Utilisateur
            WHERE t.ID_Utilisateur = %s
            """
        try:
            self.connect()
            self.cursor.execute(query, (user_id,))
            tickets = [{'id': row['ID_Ticket'], 'title': row['Titre'], 'status': row['Statut'],
                        'assigned_to': row['ID_Assignee'], 'admin_id': row['Admin_ID']} for row in self.cursor.fetchall()]
            return tickets
        except mysql.connector.Error as err:
            print(f"SQL error: {err}")
            return []

    def create_ticket(self, user_id, title, description, priority='Moyen', assignee_id=None):
        """Créer un ticket dans la base de données."""
        query = """
            INSERT INTO Tickets (Titre, Description, Date_Creation, Statut, Priorite, ID_Utilisateur, ID_Assignee)
            VALUES (%s, %s, CURDATE(), 'Ouvert', %s, %s, %s)
            """
        try:
            self.connect()
            self.cursor.execute(query, (title, description, priority, user_id, assignee_id))
            self.cnx.commit()
            return True
        except mysql.connector.Error as err:
            print("Échec de la création du ticket :", err)
            return False

    def validate_ticket(self, ticket_id):
        """Validate a ticket."""
        query = "UPDATE Tickets SET Statut = 'Validé' WHERE ID_Ticket = %s"
        try:
            self.connect()
            self.cursor.execute(query, (ticket_id,))
            self.cnx.commit()
            return True
        except mysql.connector.Error as err:
            print(f"Erreur lors de la validation du ticket : {err}")
            return False

    def close_ticket(self, ticket_id):
        """Close a ticket."""
        query = "UPDATE Tickets SET Statut = 'Fermé' WHERE ID_Ticket = %s"
        try:
            self.connect()
            self.cursor.execute(query, (ticket_id,))
            self.cnx.commit()
            return True
        except mysql.connector.Error as err:
            print(f"Erreur lors de la fermeture du ticket : {err}")
            return False
    def assign_ticket(self, ticket_id, admin_id):
        """Assigner un ticket à un autre administrateur."""
        query = "UPDATE Tickets SET ID_Assignee = %s WHERE ID_Ticket = %s"
        try:
            self.connect()
            self.cursor.execute(query, (admin_id, ticket_id))
            self.cnx.commit()
            return True
        except mysql.connector.Error as err:
            print(f"Erreur lors de l'assignation du ticket : {err}")
            return False

    def get_all_tickets(self):
        """Récupérer tous les tickets de la base de données."""
        query = "SELECT ID_Ticket, Titre, Statut, ID_Assignee FROM Tickets"
        try:
            self.connect()
            self.cursor.execute(query)
            return [{'id': row['ID_Ticket'], 'title': row['Titre'], 'status': row['Statut'], 'assigned_to': row['ID_Assignee']} for row in self.cursor.fetchall()]
        except mysql.connector.Error as err:
            print(f"Erreur SQL lors de la récupération des tickets : {err}")
            return []
