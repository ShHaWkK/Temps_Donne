import tkinter as tk
from tkinter import simpledialog, messagebox
from modules.ticket_system import TicketSystem

class BeneficiaryView:
    def __init__(self, master, user_id, ticket_system):
        self.master = master
        self.user_id = user_id
        self.ticket_system = ticket_system

        self.master.title("Beneficiary Dashboard")
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

        self.header_label = tk.Label(self.header_frame, text="Beneficiary Dashboard", font=("Arial", 18), fg="white", bg=self.primary_color)
        self.header_label.pack(pady=10)

        # Cadre des tickets
        self.tickets_frame = tk.Frame(self.main_frame, bg=self.bg_color)
        self.tickets_frame.pack(fill=tk.BOTH, expand=True, padx=20, pady=20)

        self.tickets_treeview = tk.Treeview(self.tickets_frame, columns=("Title", "Status"), show="headings")
        self.tickets_treeview.pack(fill=tk.BOTH, expand=True)

        self.tickets_treeview.heading("Title", text="Ticket Title")
        self.tickets_treeview.heading("Status", text="Status")

        self.populate_tickets()

        # Bouton de création de ticket
        self.create_ticket_button = tk.Button(self.main_frame, text="Create Ticket", command=self.create_ticket, bg=self.secondary_color, fg="white", padx=10, pady=5)
        self.create_ticket_button.pack(side=tk.BOTTOM, pady=10)

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