import tkinter as tk
from tkinter import simpledialog, messagebox
from modules.ticket_system import TicketSystem  # Assurez-vous que ce chemin d'importation est correct

class VolunteerView:
    def __init__(self, master, user_id, ticket_system):
        self.master = master
        self.user_id = user_id  # L'identifiant de l'utilisateur connecté
        self.ticket_system = ticket_system  # Le système de gestion des tickets

        self.master.title("Volunteer Dashboard")

        self.label = tk.Label(self.master, text="Volunteer Dashboard", font=("Arial", 16))
        self.label.pack(pady=20)

        self.info_label = tk.Label(self.master, text="Welcome, Volunteer! Here you can manage your activities.", font=("Arial", 12))
        self.info_label.pack(pady=10)

        self.create_ticket_button = tk.Button(self.master, text="Create Ticket", command=self.create_ticket)
        self.create_ticket_button.pack(pady=10)

    def create_ticket(self):
        title = simpledialog.askstring("Create Ticket", "Enter ticket title:")
        description = simpledialog.askstring("Create Ticket", "Enter ticket description:")
        if title and description:
            if self.ticket_system.create_ticket(self.user_id, title, description):
                messagebox.showinfo("Success", "Ticket successfully created!")
            else:
                messagebox.showerror("Error", "Failed to create the ticket")
        else:
            messagebox.showwarning("Warning", "Title and description must not be empty.")
