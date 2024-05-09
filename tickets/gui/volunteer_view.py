# gui/volunteer_view.py
import tkinter as tk
from tkinter import ttk, messagebox, simpledialog
from gui.chat_view import ChatView

class VolunteerView:
    def __init__(self, master, user_id, ticket_system, chat_manager, db_config):
        self.master = master
        self.user_id = user_id
        self.ticket_system = ticket_system
        self.chat_manager = chat_manager
        self.db_config = db_config
        self.admin_id = None
        self.ticket_id = None

        self.master.title("Espace Bénévole")
        self.master.geometry("800x600")

        self.main_frame = tk.Frame(self.master, bg="#f0f0f0")
        self.main_frame.pack(fill=tk.BOTH, expand=True)

        self.header_frame = tk.Frame(self.main_frame, bg="#4CAF50")
        self.header_frame.pack(fill=tk.X)
        self.header_label = tk.Label(self.header_frame, text="Volunteer Dashboard", font=("Arial", 18), fg="white", bg="#4CAF50")
        self.header_label.pack(pady=10)

        self.tickets_frame = tk.Frame(self.main_frame, bg="#f0f0f0")
        self.tickets_frame.pack(fill=tk.BOTH, expand=True, padx=20, pady=20)
        self.tickets_treeview = ttk.Treeview(self.tickets_frame, columns=("ID", "Title", "Status", "Admin ID"), show="headings")
        self.tickets_treeview.pack(fill=tk.BOTH, expand=True)
        self.tickets_treeview.heading("ID", text="ID du Ticket")
        self.tickets_treeview.heading("Title", text="Titre du Ticket")
        self.tickets_treeview.heading("Status", text="Statut")
        self.tickets_treeview.heading("Admin ID", text="ID de l'Admin")
        self.tickets_treeview.bind("<ButtonRelease-1>", self.open_chat_on_ticket_click)
        self.populate_tickets()

        self.create_ticket_button = tk.Button(self.main_frame, text="Créer un Ticket", command=self.create_ticket, bg="#2196F3", fg="white", padx=10, pady=5)
        self.create_ticket_button.pack(side=tk.BOTTOM, pady=10)

        self.validate_button = tk.Button(self.main_frame, text="Valider le Ticket", command=self.validate_ticket, bg="#4CAF50", fg="white", padx=10, pady=5)
        self.validate_button.pack(side=tk.BOTTOM, pady=10)

    def open_chat_on_ticket_click(self, event):
        item = self.tickets_treeview.selection()[0]
        ticket_info = self.tickets_treeview.item(item, "values")
        if ticket_info:
            print("Ticket info:", ticket_info)
            try:
                ticket_id = int(ticket_info[0])
                admin_id = int(ticket_info[3]) if ticket_info[3] else None
                print("Admin ID:", admin_id)
                self.open_chat_with_admin(ticket_id, admin_id)
            except ValueError:
                messagebox.showerror("Erreur", "ID invalide. L'ID doit être un entier.")

    def open_chat_with_admin(self, ticket_id, admin_id):
        try:
            self.ticket_id = int(ticket_id)
            self.admin_id = int(admin_id) if admin_id is not None else 0
            chat_window = tk.Toplevel(self.master)
            chat_view = ChatView(chat_window, self.user_id, self.admin_id, self.chat_manager, self.ticket_id)
        except ValueError:
            messagebox.showerror("Erreur", "L'ID doit être un entier.")

    def populate_tickets(self):
        for item in self.tickets_treeview.get_children():
            self.tickets_treeview.delete(item)
        tickets = self.ticket_system.get_tickets_by_user(self.user_id)
        for ticket in tickets:
            ticket_id = ticket.get('id', '')
            title = ticket.get('title', '')
            status = ticket.get('status', '')
            admin_id = ticket.get('admin_id', '')
            self.tickets_treeview.insert("", tk.END, values=(ticket_id, title, status, admin_id))

    def create_ticket(self):
        title = simpledialog.askstring("Créer un Ticket", "Entrez le titre du ticket :")
        description = simpledialog.askstring("Créer un Ticket", "Entrez la description du ticket :")
        if title and description:
            if self.ticket_system.create_ticket(self.user_id, title, description):
                messagebox.showinfo("Succès", "Ticket créé avec succès !")
                self.populate_tickets()
            else:
                messagebox.showerror("Erreur", "Échec de la création du ticket.")
        else:
            messagebox.showwarning("Attention", "Le titre et la description ne doivent pas être vides.")

    def validate_ticket(self):
        selected = self.tickets_treeview.selection()
        if selected:
            ticket_info = self.tickets_treeview.item(selected[0], 'values')
            ticket_id = int(ticket_info[0])
            # Call validate_ticket on TicketSystem, assuming it also closes the ticket
            if self.ticket_system.validate_ticket(ticket_id):
                messagebox.showinfo("Succès", "Ticket validé avec succès!")
                self.populate_tickets()
            else:
                messagebox.showerror("Erreur", "Échec de la validation du ticket.")
        else:
            messagebox.showwarning("Attention", "Veuillez sélectionner un ticket.")
