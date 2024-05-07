import mysql.connector

class ChatManager:
    def __init__(self, db_config):
        self.db_config = db_config
        self.connect()

    def connect(self):
        self.cnx = mysql.connector.connect(**self.db_config)
        self.cursor = self.cnx.cursor()

    def close(self):
        self.cursor.close()
        self.cnx.close()

    def send_message(self, sender_id, receiver_id, message):
        query = "INSERT INTO ChatMessages (ID_Expediteur_Utilisateur, ID_Destinataire_Utilisateur, Message, Timestamp, Lu) VALUES (%s, %s, %s, NOW(), FALSE)"
        try:
            self.cursor.execute(query, (sender_id, receiver_id, message))
            self.cnx.commit()
            return True
        except mysql.connector.Error as err:
            print(f"SQL error: {err}")
            return False

    def get_messages(self, user_id):
        query = "SELECT * FROM ChatMessages WHERE ID_Expediteur_Utilisateur = %s OR ID_Destinataire_Utilisateur = %s"
        try:
            self.cursor.execute(query, (user_id, user_id))
            return self.cursor.fetchall()
        except mysql.connector.Error as err:
            print(f"SQL error: {err}")
            return []


