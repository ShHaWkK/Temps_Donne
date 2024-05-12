import mysql.connector
from mysql.connector import errorcode


class UserManager:
    def __init__(self, db_config):
        self.db_config = db_config

    def connect(self):
        try:
            self.cnx = mysql.connector.connect(**self.db_config)
            self.cursor = self.cnx.cursor()
        except mysql.connector.Error as err:
            if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                print("Something is wrong with your user name or password")
            elif err.errno == errorcode.ER_BAD_DB_ERROR:
                print("Database does not exist")
            else:
                print(err)

    def close(self):
        self.cursor.close()
        self.cnx.close()

    def validate_user(self, email, password):
        self.connect()
        query = "SELECT ID_Utilisateur, Role FROM Utilisateurs WHERE Email = %s AND Mot_de_passe = %s"
        try:
            self.cursor.execute(query, (email, password))
            result = self.cursor.fetchone()
            if result:
                user_info = {
                    'id': result[0],
                    'role': result[1]
                }
                self.close()
                return user_info
            else:
                self.close()
                return None
        except mysql.connector.Error as err:
            print(f"SQL error: {err}")
            self.close()
            return None

    def add_user(self, user_info):
        self.connect()  # Call the connect() method before using the cursor
        query = "INSERT INTO Utilisateurs (Nom, Prenom, Genre, Email, Mot_de_passe, Role) VALUES (%s, %s, %s, %s, %s, %s)"
        try:
            self.cursor.execute(query, (
                user_info['nom'], user_info['prenom'], user_info['genre'], user_info['email'],
                user_info['mot_de_passe'],
                user_info['role']))
            self.cnx.commit()
            self.close()  # Close the connection after the operation is complete
            return self.cursor.lastrowid
        except mysql.connector.Error as err:
            print(f"SQL error: {err}")
            self.close()  # Close the connection in case of an error
            return None

        def is_admin(self, user_id):
            # Query the database to check if the user with the specified ID has the role of 'Administrateur'
            query = "SELECT Role FROM Utilisateurs WHERE ID_Utilisateur = %s"
            self.cursor.execute(query, (user_id,))
            role = self.cursor.fetchone()
            if role and role[0] == 'Administrateur':
                return True
            else:
                return False


