import tkinter as tk
from tkinter import ttk, simpledialog, messagebox
from modules.ticket_system import TicketSystem
from modules.chat_management import ChatManager
from .chat_view import ChatView


class VolunteerView:
    def __init__(self, master, user_id, ticket_system, chat_manager, db_config):
        self.master = master
        self.user_id = user_id
        self.ticket_system = ticket_system
        self.chat_manager = chat_manager
        self.db_config = db_config

        self.master.title("Espace Bénévole")
        self.master.geometry("800x600")

        # Couleurs
        self.bg_color = "#f0f0f0"
        self.primary_color = "#4CAF50"
        self.secondary_color = "#2196F3"
        self.text_color = "#333333"

        # Cadre principal
        self.main_frame = tk.Frame(self.master, bg=self.bg_color)
        self.main_frame.pack(fill=tk.BOTH, expand=True)

        # En-tête
        self.header_frame = tk.Frame(self.main_frame, bg=self.primary_color)
        self.header_frame.pack(fill=tk.X)

        self.header_label = tk.Label(self.header_frame, text="Volunteer Dashboard", font=("Arial", 18), fg="white", bg=self.primary_color)
        self.header_label.pack(pady=10)

        # Cadre des tickets
        self.tickets_frame = tk.Frame(self.main_frame, bg=self.bg_color)
        self.tickets_frame.pack(fill=tk.BOTH, expand=True, padx=20, pady=20)

        self.tickets_treeview = ttk.Treeview(self.tickets_frame, columns=("Title", "Status"), show="headings")
        self.tickets_treeview.pack(fill=tk.BOTH, expand=True)
        self.tickets_treeview.bind("<ButtonRelease-1>", self.open_chat_on_ticket_click)

        self.tickets_treeview.heading("Title", text="Ticket Title")
        self.tickets_treeview.heading("Status", text="Status")

        self.populate_tickets()

        # Bouton de création de ticket
        self.create_ticket_button = tk.Button(self.main_frame, text="Create Ticket", command=self.create_ticket, bg=self.secondary_color, fg="white", padx=10, pady=5)
        self.create_ticket_button.pack(side=tk.BOTTOM, pady=10)

        # Chat-related UI elements
        self.chat_frame = tk.Frame(self.main_frame, bg=self.bg_color)
        self.chat_frame.pack(fill=tk.BOTH, expand=True, padx=20, pady=20)

        self.chat_text = tk.Text(self.chat_frame, width=50, height=10, font=("Arial", 12))
        self.chat_text.pack(side=tk.LEFT, fill=tk.BOTH, expand=True)

        self.chat_scrollbar = tk.Scrollbar(self.chat_frame)
        self.chat_scrollbar.pack(side=tk.RIGHT, fill=tk.BOTH)

        self.chat_text.config(yscrollcommand=self.chat_scrollbar.set)
        self.chat_scrollbar.config(command=self.chat_text.yview)

        self.chat_entry = tk.Entry(self.main_frame, width=40, font=("Arial", 12))
        self.chat_entry.pack(side=tk.LEFT, padx=10, pady=10)

        self.chat_send_button = tk.Button(self.main_frame, text="Send", command=self.send_message, bg=self.secondary_color, fg="white", padx=10, pady=5)
        self.chat_send_button.pack(side=tk.LEFT, pady=10)

        self.update_chat()

    def open_chat_on_ticket_click(self, event):
        item = self.tickets_treeview.selection()[0]  # Récupère l'élément sélectionné dans l'arbre des tickets
        ticket_info = self.tickets_treeview.item(item, "values")  # Récupère les valeurs de l'élément sélectionné
        if ticket_info:
            # Supposons que les valeurs du ticket soient (ID, Title, Status), où ID est l'ID de l'administrateur
            admin_id = ticket_info[0]
            self.open_chat_with_admin(admin_id)

    def open_chat_with_admin(self, admin_id):
        chat_window = tk.Toplevel(self.master)
        chat_view = ChatView(chat_window, self.user_id, admin_id, self.chat_manager, self.db_config)
        chat_view.display_chat_window()

    def send_message(self):
        message = self.chat_entry.get()
        if message:
            # Envoyer le message au destinataire avec l'ID utilisateur actuel comme expéditeur
            self.chat_manager.send_message(self.user_id, self.user_id, message)
            self.chat_entry.delete(0, tk.END)
            self.update_chat()

    def update_chat(self):
        self.chat_text.config(state=tk.NORMAL)
        self.chat_text.delete(1.0, tk.END)

        messages = self.chat_manager.get_messages(self.user_id)
        for msg in messages:
            if msg[1] == self.user_id:  # Comparaison avec l'expéditeur de chaque message
                self.chat_text.insert(tk.END, f"You: {msg[3]}\n", 'blue')  # Insérer le message avec l'ID expéditeur
            else:
                self.chat_text.insert(tk.END, f"Admin: {msg[3]}\n", 'red')  # Insérer le message avec l'ID expéditeur
        self.chat_text.config(state=tk.DISABLED)
        self.master.after(5000, self.update_chat)

    def populate_tickets(self):
        # Clear the treeview
        for item in self.tickets_treeview.get_children():
            self.tickets_treeview.delete(item)

        # Fetch the tickets from the database
        tickets = self.ticket_system.get_tickets_by_user(self.user_id)

        # Populate the treeview
        for ticket in tickets:
            self.tickets_treeview.insert("", tk.END, values=(ticket['title'], ticket['status']))

    def create_ticket(self):
        title = simpledialog.askstring("Create Ticket", "Enter ticket title:")
        description = simpledialog.askstring("Create Ticket", "Enter ticket description:")
        if title and description:
            if self.ticket_system.create_ticket(self.user_id, title, description):
                messagebox.showinfo("Success", "Ticket successfully created!")
                self.populate_tickets()
            else:
                messagebox.showerror("Error", "Failed to create the ticket")
        else:
            messagebox.showwarning("Warning", "Title and description must not be empty.")