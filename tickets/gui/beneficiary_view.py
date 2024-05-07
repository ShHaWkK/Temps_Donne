import tkinter as tk
from tkinter import simpledialog
from modules.ticket_system import TicketSystem

class BeneficiaryView:
    def __init__(self, master, user_id, ticket_system, db_config):
        self.master = master
        self.user_id = user_id
        self.ticket_system = ticket_system
        self.db_config = db_config
        self.master.title("Beneficiary Dashboard")

        self.label = tk.Label(self.master, text="Beneficiary Dashboard", font=("Arial", 16))
        self.label.pack(pady=20)

        self.info_label = tk.Label(self.master, text="Welcome, Beneficiary! Here you can view available services and request help.", font=("Arial", 12))
        self.info_label.pack(pady=10)

        self.create_ticket_button = tk.Button(self.master, text="Create Ticket", command=self.create_ticket)
        self.create_ticket_button.pack(pady=10)

    def create_ticket(self):
        title = simpledialog.askstring("Create Ticket", "Enter ticket title:")
        description = simpledialog.askstring("Create Ticket", "Enter ticket description:")
        if title and description:
            self.ticket_system.create_ticket(self.user_id, title, description)
