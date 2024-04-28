import mysql.connector
from mysql.connector import Error

def get_connection():
    try:
        connection = mysql.connector.connect(
            host='localhost',
            port=3306,
            database='temps',
            user='root',
            password='toor'
        )
        return connection
    except Error as e:
        print(f"Error connecting to MySQL: {e}")
        return None

# Ajouter des fonctions pour gérer les utilisateurs et les messages
def check_user(email, password):
    conn = get_connection()
    if conn:
        try:
            cursor = conn.cursor(dictionary=True)
            cursor.execute("SELECT * FROM Utilisateurs WHERE Email=%s AND Mot_de_passe=%s", (email, password))
            user = cursor.fetchone()
            if user:
                user['role'] = fetch_roles_by_user(user['ID_Utilisateur'])  # Assurez-vous d'utiliser le nom correct de la colonne pour l'ID.
                return user
        finally:
            conn.close()
    return None




def fetch_tickets():
    conn = get_connection()
    if conn is not None:
        try:
            cursor = conn.cursor()
            cursor.execute("SELECT * FROM tickets")
            tickets = cursor.fetchall()
            return tickets
        finally:
            conn.close()
    return []

def add_ticket(ticket):
    conn = get_connection()
    if conn is not None:
        try:
            cursor = conn.cursor()
            cursor.execute(
                "INSERT INTO Tickets (title, description, status, creator_id) VALUES (%s, %s, %s, %s)",
                (ticket.title, ticket.description, ticket.status, ticket.creator_id)
            )
            conn.commit()
        finally:
            conn.close()

def update_ticket(ticket_id, status):
    conn = get_connection()
    if conn is not None:
        try:
            cursor = conn.cursor()
            cursor.execute("UPDATE Tickets SET status = %s WHERE id = %s", (status, ticket_id))
            conn.commit()
        finally:
            conn.close()
def fetch_messages(ticket_id):
    conn = get_connection()
    if conn:
        try:
            cursor = conn.cursor()
            cursor.execute("SELECT * FROM messages WHERE ticket_id=%s", (ticket_id,))
            messages = cursor.fetchall()
            return messages
        finally:
            conn.close()
    return []
def fetch_user_by_username(username):
    conn = get_connection()
    if conn:
        try:
            cursor = conn.cursor(dictionary=True)
            cursor.execute("SELECT * FROM Utilisateurs WHERE Email=%s", (username,))
            user = cursor.fetchone()
            return user
        finally:
            conn.close()
    return None

def check_user_password(username, password):
    user = fetch_user_by_username(username)
    return user and user['Mot_de_passe'] == password
def fetch_roles_by_user(user_id):
    conn = None
    try:
        conn = get_connection()
        cursor = conn.cursor(dictionary=True)
        query = """
            SELECT u.Role as name
            FROM Utilisateur u
            WHERE u.ID_Utilisateur = %s
        """

        cursor.execute(query, (user_id,))
        role = cursor.fetchall()
        return role
    except Error as e:
        print(f"Error fetching roles for user {user_id}: {e}")
        return []
    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()



def fetch_tickets_by_user(user_id):
    conn = get_connection()
    if conn:
        try:
            cursor = conn.cursor(dictionary=True)
            query = "SELECT * FROM tickets WHERE creator_id = %s"
            cursor.execute(query, (user_id,))
            tickets = cursor.fetchall()
            return tickets
        except Error as e:
            print("Error fetching tickets for user:", e)
            return []
        finally:
            if conn:
                conn.close()
    return []


def delete_ticket_from_db(ticket_id):
    conn = get_connection()
    if conn:
        try:
            cursor = conn.cursor()
            cursor.execute("DELETE FROM tickets WHERE id=%s", (ticket_id,))
            conn.commit()
        finally:
            conn.close()
def send_message_to_db(ticket_id, message, user_id):
    conn = get_connection()
    if conn:
        try:
            cursor = conn.cursor()
            cursor.execute("INSERT INTO messages (ticket_id, content, user_id) VALUES (%s, %s, %s)", (ticket_id, message, user_id))
            conn.commit()
        finally:
            conn.close()

def refresh_messages(ticket_id):
    conn = get_connection()
    if conn:
        try:
            cursor = conn.cursor()
            cursor.execute("SELECT content FROM messages WHERE ticket_id=%s ORDER BY message_time DESC", (ticket_id,))
            messages = cursor.fetchall()
            return messages
        finally:
            conn.close()
