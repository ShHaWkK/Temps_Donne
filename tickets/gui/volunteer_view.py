import tkinter as tk
from tkinter import ttk, simpledialog, messagebox
from gui.chat_view import ChatView

class VolunteerView:
    def __init__(self, master, user_id, ticket_system, chat_manager, db_config):
        self.master = master
        self.user_id = user_id
        self.ticket_system = ticket_system
        self.chat_manager = chat_manager
        self.db_config = db_config
        self.admin_id = None

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
        self.tickets_treeview = ttk.Treeview(self.tickets_frame, columns=("Title", "Status", "Admin ID"), show="headings")
        self.tickets_treeview.pack(fill=tk.BOTH, expand=True)
        self.tickets_treeview.heading("Title", text="Ticket Title")
        self.tickets_treeview.heading("Status", text="Status")
        self.tickets_treeview.heading("Admin ID", text="Admin ID")
        self.tickets_treeview.bind("<ButtonRelease-1>", self.open_chat_on_ticket_click)
        self.populate_tickets()

        self.create_ticket_button = tk.Button(self.main_frame, text="Create Ticket", command=self.create_ticket, bg="#2196F3", fg="white", padx=10, pady=5)
        self.create_ticket_button.pack(side=tk.BOTTOM, pady=10)

        self.chat_frame = tk.Frame(self.main_frame, bg="#f0f0f0")
        self.chat_frame.pack(fill=tk.BOTH, expand=True, padx=20, pady=20)
        self.chat_text = tk.Text(self.chat_frame, width=50, height=10, font=("Arial", 12))
        self.chat_text.pack(side=tk.LEFT, fill=tk.BOTH, expand=True)
        self.chat_scrollbar = tk.Scrollbar(self.chat_frame)
        self.chat_scrollbar.pack(side=tk.RIGHT, fill=tk.BOTH)
        self.chat_text.config(yscrollcommand=self.chat_scrollbar.set)
        self.chat_scrollbar.config(command=self.chat_text.yview)
        self.chat_entry = tk.Entry(self.main_frame, width=40, font=("Arial", 12))
        self.chat_entry.pack(side=tk.LEFT, padx=10, pady=10)
        self.chat_send_button = tk.Button(self.main_frame, text="Send", command=self.send_message, bg="#2196F3", fg="white", padx=10, pady=5)
        self.chat_send_button.pack(side=tk.LEFT, pady=10)
        self.update_chat()

    def open_chat_on_ticket_click(self, event):
        item = self.tickets_treeview.selection()[0]
        ticket_info = self.tickets_treeview.item(item, "values")
        if ticket_info:
            print("Ticket info:", ticket_info)
            try:
                admin_id = int(ticket_info[2])  # Assurez-vous que c'est un entier
                print("Admin ID:", admin_id)
                self.open_chat_with_admin(admin_id)
            except ValueError:
                messagebox.showerror("Error", "Invalid admin ID. ID must be an integer.")

    def populate_tickets(self):
        for item in self.tickets_treeview.get_children():
            self.tickets_treeview.delete(item)
        tickets = self.ticket_system.get_tickets_by_user(self.user_id)
        for ticket in tickets:
            title = ticket.get('title', '')
            status = ticket.get('status', '')
            admin_id = ticket.get('admin_id', '')  # Utilisez la clé admin_id pour obtenir l'ID de l'administrateur
            self.tickets_treeview.insert("", tk.END, values=(title, status, admin_id))
    def open_chat_with_admin(self, admin_id):
        try:
            self.admin_id = int(admin_id)  # Store the admin_id as an attribute
            chat_window = tk.Toplevel(self.master)
            chat_view = ChatView(chat_window, self.user_id, self.admin_id, self.chat_manager)
            chat_window.mainloop()
        except ValueError:
            messagebox.showerror("Error", "Invalid admin ID. ID must be an integer.")

    def send_message(self):
        message = self.chat_entry.get()
        if message:
            self.chat_manager.send_message(self.user_id, self.user_id, message)
            self.chat_entry.delete(0, tk.END)
            self.update_chat()

    def update_chat(self):
        self.chat_text.config(state=tk.NORMAL)
        self.chat_text.delete(1.0, tk.END)
        messages = self.chat_manager.get_messages(self.user_id, self.admin_id)
        for msg in messages:
            if msg[1] == self.user_id:
                self.chat_text.insert(tk.END, f"You: {msg[3]}\n", 'blue')
            else:
                self.chat_text.insert(tk.END, f"Admin: {msg[3]}\n", 'red')
        self.chat_text.config(state=tk.DISABLED)
        self.master.after(5000, self.update_chat)

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
