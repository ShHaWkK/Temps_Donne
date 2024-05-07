import tkinter as tk
from tkinter import ttk, messagebox
from modules.chat_management import ChatManager
from tkinter import simpledialog

class AdminView:
    def __init__(self, master, ticket_system, chat_manager):
        self.master = master
        self.ticket_system = ticket_system
        self.chat_manager = chat_manager

        self.master.title("Admin Dashboard")

        self.frame = tk.Frame(self.master)
        self.tickets_treeview = ttk.Treeview(self.frame)
        self.tickets_treeview['columns'] = ('ID', 'Title', 'Status', 'Assigned To')
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
        # Clear the treeview
        for item in self.tickets_treeview.get_children():
            self.tickets_treeview.delete(item)

        # Fetch the tickets from the database
        tickets = self.ticket_system.get_all_tickets()

        # Populate the treeview
        for ticket in tickets:
            self.tickets_treeview.insert('', 'end', text=ticket['id'], values=(
                ticket['id'],
                ticket['title'],
                ticket['status'],
                ticket['assigned_to']
            ))

    def close_ticket(self):
        selected_item = self.tickets_treeview.focus()
        if selected_item:
            ticket_id = self.tickets_treeview.item(selected_item)['text']
            if self.ticket_system.close_ticket(ticket_id):
                self.list_tickets()
            else:
                messagebox.showerror("Error", "Failed to close the ticket.")

    def validate_ticket(self):
        selected_item = self.tickets_treeview.focus()
        if selected_item:
            ticket_id = self.tickets_treeview.item(selected_item)['text']
            if self.ticket_system.validate_ticket(ticket_id):
                self.list_tickets()
            else:
                messagebox.showerror("Error", "Failed to validate the ticket.")

    def assign_admin(self, ticket_id, admin_id):
        # Add code to assign the ticket to the specified admin
        if self.ticket_system.assign_ticket(ticket_id, admin_id):
            self.list_tickets()
        else:
            messagebox.showerror("Error", "Failed to assign the ticket to another administrator.")

    def show_ticket_messages(self):
        selected_item = self.tickets_treeview.focus()
        if selected_item:
            ticket_id = self.tickets_treeview.item(selected_item)['text']
            messages = self.chat_manager.get_ticket_messages(ticket_id)
            # Add code to display the message history in a new window or dialog
            # ...

    def send_message(self):
        selected_item = self.tickets_treeview.focus()
        if selected_item:
            ticket_id = self.tickets_treeview.item(selected_item)['text']
            message = simpledialog.askstring("Send Message", "Enter your message:")
            if message:
                if self.chat_manager.send_message(self.user_id, ticket_id, message):
                    self.show_ticket_messages(ticket_id)
                else:
                    messagebox.showerror("Error", "Failed to send the message.")
