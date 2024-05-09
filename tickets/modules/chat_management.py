import mysql.connector

class ChatManager:
    def __init__(self, db_config):
        self.db_config = db_config
        self.connection = None
        self.cursor = None

    def connect(self):
        if not self.connection or not self.connection.is_connected():
            self.connection = mysql.connector.connect(**self.db_config)
            self.cursor = self.connection.cursor(dictionary=True)

    def close(self):
        if self.cursor:
            self.cursor.close()
        if self.connection:
            self.connection.close()
            self.connection = None
            self.cursor = None

    def send_message(self, sender_id, receiver_id, message, ticket_id):
        try:
            sender_id = int(sender_id)
            receiver_id = int(receiver_id)
            ticket_id = int(ticket_id)
            self.connect()
            query = "INSERT INTO ChatMessages (ID_Expediteur_Utilisateur, ID_Destinataire_Utilisateur, Message, ticket_id) VALUES (%s, %s, %s, %s)"
            self.cursor.execute(query, (sender_id, receiver_id, message, ticket_id))
            self.connection.commit()
            return True
        except ValueError:
            print("Les identifiants doivent être des entiers.")
            return False
        except mysql.connector.Error as err:
            print(f"Échec de l'envoi du message : {err}")
            return False

    def get_ticket_messages(self, ticket_id):
        query = """
        SELECT Message, ID_Expediteur_Utilisateur, ID_Destinataire_Utilisateur, Timestamp
        FROM ChatMessages
        WHERE ticket_id = %s
        ORDER BY Timestamp ASC
        """
        try:
            self.connect()
            self.cursor.execute(query, (ticket_id,))
            return self.cursor.fetchall()
        except mysql.connector.Error as err:
            print(f"Échec de la récupération des messages : {err}")
            return []

    def send_admin_message(self, ticket_id, message, admin_id):
        try:
            ticket_id = int(ticket_id)
            admin_id = int(admin_id)
            self.connect()
            query = "INSERT INTO ChatMessages (ID_Expediteur_Utilisateur, Message, ticket_id) VALUES (%s, %s, %s)"
            self.cursor.execute(query, (admin_id, message, ticket_id))
            self.connection.commit()
            return True
        except ValueError:
            print("Ticket ID doit être un entier.")
            return False
        except mysql.connector.Error as err:
            print(f"Échec de l'envoi du message d'administration : {err}")
            return False

    def get_user_name(self, user_id):
        query = "SELECT Nom FROM Utilisateurs WHERE ID_Utilisateur = %s"
        try:
            self.connect()
            self.cursor.execute(query, (user_id,))
            result = self.cursor.fetchone()
            return result['Nom'] if result else None
        except mysql.connector.Error as err:
            print(f"Échec de la récupération du nom de l'utilisateur : {err}")
            return None
