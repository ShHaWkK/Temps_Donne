import tkinter as tk
from tkinter import messagebox, ttk, scrolledtext
from database import (fetch_tickets, add_ticket, update_ticket, check_user,
                      fetch_messages, delete_ticket_from_db, send_message_to_db,
                      fetch_tickets_by_user)
from models import Ticket

class AppUI(tk.Tk):
    def __init__(self):
        super().__init__()
        self.title("Ticket Management System")
        self.geometry("800x600")
        self.current_user = None  # Store the current user details
        self.setup_login()

    def setup_login(self):
        self.login_frame = ttk.Frame(self)
        self.login_frame.pack(padx=10, pady=10)

        ttk.Label(self.login_frame, text="Email:").grid(row=0, column=0)
        self.username_entry = ttk.Entry(self.login_frame)
        self.username_entry.grid(row=0, column=1)

        ttk.Label(self.login_frame, text="Password:").grid(row=1, column=0)
        self.password_entry = ttk.Entry(self.login_frame, show="*")
        self.password_entry.grid(row=1, column=1)

        ttk.Button(self.login_frame, text="Login", command=self.login).grid(row=2, column=0, columnspan=2)

    def login(self):
        email = self.username_entry.get()
        password = self.password_entry.get()
        user = check_user(email, password)
        if user:
            self.current_user = user
            self.setup_user_ui()
        else:
            messagebox.showerror("Échec de la connexion", "Email ou mot de passe invalide")

    def setup_user_ui(self):
        if 'Administrateur' in [role['name'] for role in self.current_user['roles']]:  # Vérifier le rôle
            self.setup_admin_ui()
        else:
            self.setup_volunteer_ui()

    def setup_volunteer_ui(self):
        self.clear_ui()
        ttk.Label(self, text="Créer un Ticket").pack(pady=10)

        ttk.Label(self, text="Titre:").pack()
        self.title_entry = ttk.Entry(self, width=50)
        self.title_entry.pack()

        ttk.Label(self, text="Description:").pack()
        self.desc_text = tk.Text(self, height=10, width=50)
        self.desc_text.pack()

        ttk.Button(self, text="Soumettre le Ticket", command=self.submit_ticket).pack(pady=10)

        ttk.Label(self, text="Vos Tickets:").pack(pady=10)
        self.user_ticket_list = ttk.Treeview(self, columns=("ID", "Title", "Status"), show="headings")
        self.user_ticket_list.heading("ID", text="ID")
        self.user_ticket_list.heading("Title", text="Titre")
        self.user_ticket_list.heading("Status", text="Statut")
        self.user_ticket_list.pack(expand=True, fill='both', padx=20, pady=20)

        self.load_user_tickets()

    def submit_ticket(self):
        title = self.title_entry.get()
        description = self.desc_text.get("1.0", tk.END)
        # Make sure you are using the correct key for the user's ID
        new_ticket = Ticket(None, title, description, "Nouveau", "Normal", self.current_user['ID_Utilisateur'], None)
        add_ticket(new_ticket)
        messagebox.showinfo("Succès", "Ticket créé avec succès!")
        self.load_user_tickets()

    def load_user_tickets(self):
        self.user_ticket_list.delete(*self.user_ticket_list.get_children())
        for ticket in fetch_tickets_by_user(self.current_user['ID_Utilisateur']):
            self.user_ticket_list.insert("", tk.END, values=(ticket['id'], ticket['title'], ticket['status']))

    def load_user_tickets(self):
        self.user_ticket_list.delete(*self.user_ticket_list.get_children())
        for ticket in fetch_tickets_by_user(self.current_user.id):
            self.user_ticket_list.insert("", tk.END, values=(ticket.id, ticket.title, ticket.status))

    def setup_admin_ui(self):
        self.clear_ui()
        ttk.Label(self, text="Tous les Tickets:").pack(pady=10)
        self.admin_ticket_list = ttk.Treeview(self, columns=("ID", "Title", "Status"), show="headings")
        self.admin_ticket_list.heading("ID", text="ID")
        self.admin_ticket_list.heading("Title", text="Titre")
        self.admin_ticket_list.heading("Status", text="Statut")
        self.admin_ticket_list.pack(expand=True, fill='both', padx=20, pady=20)

        ttk.Button(self, text="Valider le Ticket", command=self.validate_ticket).pack(side=tk.LEFT, padx=10)
        ttk.Button(self, text="Supprimer le Ticket", command=self.delete_selected_ticket).pack(side=tk.RIGHT, padx=10)

        self.load_all_tickets()

    def load_all_tickets(self):
        self.admin_ticket_list.delete(*self.admin_ticket_list.get_children())
        for ticket in fetch_tickets():
            self.admin_ticket_list.insert("", tk.END, values=(ticket.id, ticket.title, ticket.status))

    def validate_ticket(self):
        selected_item = self.admin_ticket_list.selection()
        if selected_item:
            ticket_id = self.admin_ticket_list.item(selected_item[0])['values'][0]
            update_ticket(ticket_id, "Validé")
            messagebox.showinfo("Ticket Validé", "Le ticket a été validé avec succès!")
            self.load_all_tickets()

    def delete_selected_ticket(self):
        selected_item = self.admin_ticket_list.selection()
        if selected_item:
            ticket_id = self.admin_ticket_list.item(selected_item[0])['values'][0]
            delete_ticket_from_db(ticket_id)
            messagebox.showinfo("Ticket Supprimé", "Le ticket a été supprimé avec succès!")
            self.load_all_tickets()

    def clear_ui(self):
        # Effacer tous les widgets de l'interface utilisateur actuelle sans rappeler setup_main_ui
        for widget in self.winfo_children():
            widget.destroy()

    def setup_main_ui(self):
        # Just set up the main UI without calling clear_ui again
        welcome_label = ttk.Label(self, text=f"Welcome {self.current_user['Email']}", font=('Helvetica', 16))
        welcome_label.pack(pady=20)

        # Optionally, you can provide more navigation or status information here
        if 'Administrator' in self.current_user.roles:
            admin_button = ttk.Button(self, text="Administrator Dashboard", command=self.setup_admin_ui)
            admin_button.pack(pady=10)

        volunteer_button = ttk.Button(self, text="Volunteer Dashboard", command=self.setup_volunteer_ui)
        volunteer_button.pack(pady=10)

        # Log out button
        logout_button = ttk.Button(self, text="Log Out", command=self.logout)
        logout_button.pack(pady=20)

    def logout(self):
        # Reset current_user and show the login screen
        self.current_user = None
        self.setup_login()


if __name__ == "__main__":
    app = AppUI()
    app.mainloop()
