import tkinter as tk
from tkinter import ttk, messagebox, simpledialog
from gui.admin_chat import AdminChatView
import mysql.connector

class AdminView:
    def __init__(self, master, ticket_system, chat_manager, db_config):
        self.master = master
        self.ticket_system = ticket_system
        self.chat_manager = chat_manager
        self.db_connection = mysql.connector.connect(**db_config)

        self.master.title("Admin Dashboard")
        self.master.geometry("800x600")

        self.frame = tk.Frame(self.master)
        self.frame.pack(fill='both', expand=True)

        self.tickets_treeview = ttk.Treeview(self.frame, columns=('ID', 'Title', 'Status', 'Assigned To'))
        self.tickets_treeview.heading('#0', text='ID')
        self.tickets_treeview.heading('Title', text='Title')
        self.tickets_treeview.heading('Status', text='Status')
        self.tickets_treeview.heading('Assigned To', text='Assigned To')
        self.tickets_treeview.pack(fill='both', expand=True, padx=10, pady=10)

        button_frame = tk.Frame(self.frame)
        button_frame.pack(pady=10)

        self.close_ticket_button = tk.Button(button_frame, text="Close Ticket", command=self.close_ticket)
        self.validate_ticket_button = tk.Button(button_frame, text="Validate Ticket", command=self.validate_ticket)
        self.assign_admin_button = tk.Button(button_frame, text="Assign Admin", command=self.assign_admin)
        self.show_messages_button = tk.Button(button_frame, text="Show Messages", command=self.show_ticket_messages)
        self.send_message_button = tk.Button(button_frame, text="Send Message", command=self.send_message)

        self.close_ticket_button.pack(side=tk.LEFT, padx=5)
        self.validate_ticket_button.pack(side=tk.LEFT, padx=5)
        self.assign_admin_button.pack(side=tk.LEFT, padx=5)
        self.show_messages_button.pack(side=tk.LEFT, padx=5)
        self.send_message_button.pack(side=tk.LEFT, padx=5)

        self.list_tickets()

    def list_tickets(self):
        for item in self.tickets_treeview.get_children():
            self.tickets_treeview.delete(item)

        tickets = self.ticket_system.get_all_tickets()
        for ticket in tickets:
            self.tickets_treeview.insert('', 'end', text=ticket['id'], values=(
                ticket['id'], ticket['title'], ticket['status'], ticket['assigned_to']
            ))

    def close_ticket(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        if self.ticket_system.close_ticket(ticket_id):
            self.list_tickets()
            messagebox.showinfo("Succès", "Ticket fermé avec succès.")
        else:
            messagebox.showerror("Erreur", "Échec de la fermeture du ticket.")

    def validate_ticket(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        if self.ticket_system.validate_ticket(ticket_id):
            self.list_tickets()
            messagebox.showinfo("Succès", "Ticket validé avec succès.")
        else:
            messagebox.showerror("Erreur", "Échec de la validation du ticket.")

    def assign_admin(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        admin_id = self.select_admin()
        if admin_id:
            self.assign_ticket(ticket_id, admin_id)

    def is_admin(self, user_id):
        try:
            cursor = self.db_connection.cursor()
            query = "SELECT Role FROM Utilisateurs WHERE ID_Utilisateur = %s"
            cursor.execute(query, (user_id,))
            role = cursor.fetchone()
            cursor.close()
            return role and role[0] == 'Administrateur'
        except mysql.connector.Error as err:
            print(f"Erreur : {err}")
            return False

    def select_admin(self):
        admins = self.get_all_admins()

        window = tk.Toplevel(self.master)
        window.title("Sélectionner un Administrateur")
        window.geometry("300x150")

        tk.Label(window, text="Choisissez un administrateur :").pack(pady=10)

        selected_admin = tk.StringVar()
        admin_menu = ttk.Combobox(window, textvariable=selected_admin, values=admins)
        admin_menu.pack(pady=10)
        admin_menu.current(0)

        def assign():
            window.destroy()

        assign_button = tk.Button(window, text="Assigner", command=assign)
        assign_button.pack(pady=10)

        window.wait_window()
        return selected_admin.get().split(":")[0]  # Renvoie l'ID de l'admin

    def get_all_admins(self):
        try:
            cursor = self.db_connection.cursor()
            query = "SELECT ID_Utilisateur, Nom FROM Utilisateurs WHERE Role = 'Administrateur'"
            cursor.execute(query)
            admins = [f"{row[0]}: {row[1]}" for row in cursor.fetchall()]
            cursor.close()
            return admins
        except mysql.connector.Error as err:
            print(f"Erreur : {err}")
            return []
    def assign_ticket(self, ticket_id, admin_id):
        try:
            cursor = self.db_connection.cursor()
            query = "UPDATE Tickets SET ID_Assignee = %s WHERE ID_Ticket = %s"
            cursor.execute(query, (admin_id, ticket_id))
            self.db_connection.commit()
            cursor.close()
            self.list_tickets()
        except mysql.connector.Error as err:
            print(f"Erreur : {err}")

    def show_ticket_messages(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        chat_window = tk.Toplevel(self.master)
        AdminChatView(chat_window, ticket_id, self.chat_manager)

    def send_message(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        message = simpledialog.askstring("Envoyer un message", "Entrez votre message :")
        if message and self.chat_manager.send_admin_message(ticket_id, message):
            self.show_ticket_messages()
        else:
            messagebox.showerror("Erreur", "Échec de l'envoi du message.")
