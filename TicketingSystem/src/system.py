import mysql.connector
from mysql.connector import Error
import tkinter as tk
from tkinter import ttk, messagebox


def connect_db():
    try:
        connection = mysql.connector.connect(
            host='db',
            port=3306,
            database='temps',
            user='root',
            password='toor'
        )
        if connection.is_connected():
            return connection
    except Error as e:
        print(f"Error connecting to MySQL: {e}")
        return None


def create_ticket(description, admin, status="open"):
    connection = connect_db()
    if connection:
        try:
            cursor = connection.cursor()
            query = "INSERT INTO tickets (description, admin, status) VALUES (%s, %s, %s)"
            cursor.execute(query, (description, admin, status))
            connection.commit()
            messagebox.showinfo("Success", "Ticket created successfully.")
        except Error as e:
            messagebox.showerror("Error", f"Failed to create ticket: {e}")
        finally:
            connection.close()
    else:
        messagebox.showerror("Connection Error", "Failed to connect to the database.")


def list_tickets():
    connection = connect_db()
    if connection:
        try:
            cursor = connection.cursor()
            cursor.execute("SELECT id, description, admin, status FROM tickets")
            result = cursor.fetchall()
            return result
        except Error as e:
            messagebox.showerror("Error", f"Failed to list tickets: {e}")
            return []
        finally:
            connection.close()
    else:
        messagebox.showerror("Connection Error", "Failed to connect to the database.")
        return []


def update_ticket_status(ticket_id, new_status):
    connection = connect_db()
    if connection:
        try:
            cursor = connection.cursor()
            query = "UPDATE tickets SET status = %s WHERE id = %s"
            cursor.execute(query, (new_status, ticket_id))
            connection.commit()
            messagebox.showinfo("Success", "Ticket status updated successfully.")
        except Error as e:
            messagebox.showerror("Error", f"Failed to update ticket status: {e}")
        finally:
            connection.close()
    else:
        messagebox.showerror("Connection Error", "Failed to connect to the database.")


class TicketApp(tk.Tk):
    def __init__(self):
        super().__init__()
        self.title("Ticket Management System")
        self.geometry("600x400")

        self.create_widgets()

    def create_widgets(self):
        # Input fields
        tk.Label(self, text="Description:").grid(row=0, column=0)
        self.description_entry = tk.Entry(self)
        self.description_entry.grid(row=0, column=1)

        tk.Label(self, text="Admin:").grid(row=1, column=0)
        self.admin_entry = tk.Entry(self)
        self.admin_entry.grid(row=1, column=1)

        # Buttons
        tk.Button(self, text="Create Ticket", command=self.on_create_ticket).grid(row=2, column=1, sticky=tk.W + tk.E)
        tk.Button(self, text="Refresh List", command=self.refresh_tickets).grid(row=2, column=0, sticky=tk.W + tk.E)

        # Ticket list
        self.ticket_list = ttk.Treeview(self, columns=("ID", "Description", "Admin", "Status"), show="headings")
        self.ticket_list.grid(row=3, column=0, columnspan=2, sticky="nsew")
        for col in self.ticket_list['columns']:
            self.ticket_list.heading(col, text=col)

        # Update status
        tk.Label(self, text="Ticket ID:").grid(row=4, column=0)
        self.ticket_id_entry = tk.Entry(self)
        self.ticket_id_entry.grid(row=4, column=1)

        tk.Label(self, text="New Status:").grid(row=5, column=0)
        self.new_status_entry = tk.Entry(self)
        self.new_status_entry.grid(row=5, column=1)

        tk.Button(self, text="Update Status", command=self.on_update_status).grid(row=6, column=0, columnspan=2,
                                                                                  sticky=tk.W + tk.E)

        self.refresh_tickets()

    def on_create_ticket(self):
        description = self.description_entry.get()
        admin = self.admin_entry.get()
        if description and admin:
            create_ticket(description, admin)
            self.refresh_tickets()
        else:
            messagebox.showerror("Error", "Description and Admin cannot be empty.")

    def refresh_tickets(self):
        for i in self.ticket_list.get_children():
            self.ticket_list.delete(i)
        tickets = list_tickets()
        for ticket in tickets:
            self.ticket_list.insert("", "end", values=ticket)

    def on_update_status(self):
        ticket_id = self.ticket_id_entry.get()
        new_status = self.new_status_entry.get()
        if ticket_id and new_status:
            update_ticket_status(ticket_id, new_status)
            self.refresh_tickets()
        else:
            messagebox.showerror("Error", "Ticket ID and New Status cannot be empty.")


if __name__ == "__main__":
    app = TicketApp()
    app.mainloop()

# Page de connexion => Authentification
# page des tickets => pour voir les listes de trickets traités, chatbox,
# Conversation
# Bouton Valider, supprimer
#traiter par le nom de l'administrateur
# color : red => occupé, jaune => en cours et vert => fait