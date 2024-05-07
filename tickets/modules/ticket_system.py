import mysql.connector

class TicketSystem:
    def __init__(self, db_config):
        self.db_config = db_config
        self.connect()

    def connect(self):
        self.cnx = mysql.connector.connect(**self.db_config)
        self.cursor = self.cnx.cursor()

    def close(self):
        self.cursor.close()
        self.cnx.close()

    def create_ticket(self, user_id, title, description):
        query = "INSERT INTO Tickets (Titre, Description, ID_Utilisateur, Statut, Date_Creation) VALUES (%s, %s, %s, 'Ouvert', NOW())"
        try:
            self.cursor.execute(query, (title, description, user_id))
            self.cnx.commit()
            return self.cursor.lastrowid
        except mysql.connector.Error as err:
            print(f"SQL error: {err}")
            return None

    def close_ticket(self, ticket_id):
        query = "UPDATE Tickets SET Statut = 'Fermé' WHERE ID_Ticket = %s"
        try:
            self.cursor.execute(query, (ticket_id,))
            self.cnx.commit()
            return True
        except mysql.connector.Error as err:
            print(f"SQL error: {err}")
            return False

    def get_tickets_by_user(self, user_id):
        query = "SELECT * FROM Tickets WHERE ID_Utilisateur = %s"
        try:
            self.cursor.execute(query, (user_id,))
            return self.cursor.fetchall()
        except mysql.connector.Error as err:
            print(f"SQL error: {err}")
            return []
