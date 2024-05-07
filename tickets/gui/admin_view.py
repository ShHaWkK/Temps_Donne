import tkinter as tk
from tkinter import ttk, messagebox, simpledialog
import mysql.connector

class AdminView:
    def __init__(self, master, ticket_system, chat_manager, db_config):
        self.master = master
        self.ticket_system = ticket_system
        self.chat_manager = chat_manager
        self.db_config = db_config
        self.db_connection = mysql.connector.connect(**self.db_config)
        self.db_cursor = self.db_connection.cursor()

        self.master.title("Admin Dashboard")

        self.frame = tk.Frame(self.master)
        self.tickets_treeview = ttk.Treeview(self.frame, columns=('ID', 'Title', 'Status', 'Assigned To'))
        self.tickets_treeview.heading('#0', text='ID')
        self.tickets_treeview.heading('Title', text='Title')
        self.tickets_treeview.heading('Status', text='Status')
        self.tickets_treeview.heading('Assigned To', text='Assigned To')
        self.tickets_treeview.pack(fill='both', expand=True)

        self.close_ticket_button = tk.Button(self.frame, text="Close Ticket", command=self.close_ticket)
        self.validate_ticket_button = tk.Button(self.frame, text="Validate Ticket", command=self.validate_ticket)
        self.assign_admin_button = tk.Button(self.frame, text="Assign Admin", command=self.assign_admin)
        self.show_messages_button = tk.Button(self.frame, text="Show Messages", command=self.show_ticket_messages)
        self.send_message_button = tk.Button(self.frame, text="Send Message", command=self.send_message)

        self.close_ticket_button.pack(side=tk.LEFT, padx=5, pady=5)
        self.validate_ticket_button.pack(side=tk.LEFT, padx=5, pady=5)
        self.assign_admin_button.pack(side=tk.LEFT, padx=5, pady=5)
        self.show_messages_button.pack(side=tk.LEFT, padx=5, pady=5)
        self.send_message_button.pack(side=tk.LEFT, padx=5, pady=5)

        self.frame.pack(fill='both', expand=True)

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
        else:
            messagebox.showerror("Error", "Failed to close the ticket.")

    def validate_ticket(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        if self.ticket_system.validate_ticket(ticket_id):
            self.list_tickets()
        else:
            messagebox.showerror("Error", "Failed to validate the ticket.")

    def assign_admin(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        admin_id = simpledialog.askinteger("Assign Admin", "Enter the ID of the admin:")
        if admin_id is not None:
            if self.is_admin(admin_id):
                self.assign_ticket(ticket_id, admin_id)
            else:
                messagebox.showerror("Error", "You can only assign tickets to administrators.")

    def is_admin(self, user_id):
        query = "SELECT Role FROM Utilisateurs WHERE ID_Utilisateur = %s"
        cursor = self.db_connection.cursor()
        cursor.execute(query, (user_id,))
        role = cursor.fetchone()
        cursor.close()
        return role and role[0] == 'Administrateur'

    def assign_ticket(self, ticket_id, admin_id):
        query = "UPDATE Tickets SET ID_Assignee = %s WHERE ID_Ticket = %s"
        cursor = self.db_connection.cursor()
        cursor.execute(query, (admin_id, ticket_id))
        self.db_connection.commit()
        cursor.close()
        self.list_tickets()

    def show_ticket_messages(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        messages = self.chat_manager.get_ticket_messages(ticket_id)
        # Display message history

    def send_message(self):
        selected_item = self.tickets_treeview.focus()
        ticket_id = self.tickets_treeview.item(selected_item)['text']
        message = simpledialog.askstring("Send Message", "Enter your message:")
        if message and self.chat_manager.send_message(self.user_id, ticket_id, message):
            self.show_ticket_messages(ticket_id)
        else:
            messagebox.showerror("Error", "Failed to send the message.")
