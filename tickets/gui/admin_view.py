import tkinter as tk
from tkinter import ttk, messagebox, simpledialog
from gui.admin_chat import AdminChatView
import mysql.connector

class AdminView:
    def __init__(self, master, ticket_system, chat_manager, db_config, admin_id):
        self.master = master
        self.ticket_system = ticket_system
        self.chat_manager = chat_manager
        self.admin_id = admin_id
        self.db_connection = mysql.connector.connect(**db_config)

        self.master.title("Tableau de bord de l'administrateur")
        self.master.geometry("800x600")

        # Couleurs
        self.bg_color = "#f0f0f0"
        self.primary_color = "#4CAF50"
        self.secondary_color = "#2196F3"
        self.text_color = "#333333"

        # Cadre principal
        self.main_frame = tk.Frame(self.master, bg=self.bg_color)
        self.main_frame.pack(fill='both', expand=True)

        # En-tête
        self.header_frame = tk.Frame(self.main_frame, bg=self.primary_color)
        self.header_frame.pack(fill=tk.X)
        self.header_label = tk.Label(self.header_frame, text="Tableau de bord de l'administrateur", font=("Arial", 18), fg="white", bg=self.primary_color)
        self.header_label.pack(pady=10)

        # Cadre des tickets
        self.tickets_frame = tk.Frame(self.main_frame, bg=self.bg_color)
        self.tickets_frame.pack(fill='both', expand=True, padx=20, pady=20)

        self.tickets_treeview = ttk.Treeview(self.tickets_frame, columns=('ID', 'Titre', 'Statut', 'Assigné à'))
        self.tickets_treeview.heading('#0', text='ID')
        self.tickets_treeview.heading('Titre', text='Titre')
        self.tickets_treeview.heading('Statut', text='Statut')
        self.tickets_treeview.heading('Assigné à', text='Assigné à')
        self.tickets_treeview.pack(fill='both', expand=True)

        # Cadre des boutons
        self.buttons_frame = tk.Frame(self.main_frame, bg=self.bg_color)
        self.buttons_frame.pack(pady=10)

        self.close_ticket_button = tk.Button(self.buttons_frame, text="Fermer le ticket", command=self.close_ticket, bg=self.secondary_color, fg="white", padx=10, pady=5)
        self.validate_ticket_button = tk.Button(self.buttons_frame, text="Valider le ticket", command=self.validate_ticket, bg=self.secondary_color, fg="white", padx=10, pady=5)
        self.assign_admin_button = tk.Button(self.buttons_frame, text="Assigner un administrateur", command=self.assign_admin, bg=self.secondary_color, fg="white", padx=10, pady=5)
        self.show_messages_button = tk.Button(self.buttons_frame, text="Afficher les messages", command=self.show_ticket_messages, bg=self.secondary_color, fg="white", padx=10, pady=5)
        self.send_message_button = tk.Button(self.buttons_frame, text="Envoyer un message", command=self.send_message, bg=self.secondary_color, fg="white", padx=10, pady=5)

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
        return selected_admin.get().split(":")[0]

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
        if self.ticket_system.assign_ticket(ticket_id, admin_id):
            self.list_tickets()
        else:
            messagebox.showerror("Erreur", "Échec de l'assignation du ticket.")

    def show_ticket_messages(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        chat_window = tk.Toplevel(self.master)
        AdminChatView(chat_window, ticket_id, self.chat_manager, self.admin_id)

    def send_message(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        message = simpledialog.askstring("Envoyer un Message", "Entrez votre message :")
        if message and self.chat_manager.send_admin_message(ticket_id, message, self.admin_id):
            self.show_ticket_messages()
        else:
            messagebox.showerror("Erreur", "Impossible d'envoyer le message.")
