import tkinter as tk
from tkinter import scrolledtext, messagebox

class ChatView:
    def __init__(self, master, user_id, other_user_id, chat_manager, ticket_id):
        self.master = master
        self.user_id = user_id
        self.other_user_id = other_user_id
        self.ticket_id = ticket_id
        self.chat_manager = chat_manager

        self.master.title("Chat")

        self.chat_box = scrolledtext.ScrolledText(master, state='disabled')
        self.chat_box.pack(pady=10, padx=10)

        self.msg_entry = tk.Entry(master)
        self.msg_entry.pack(side=tk.LEFT, expand=True, fill=tk.X, padx=10)

        self.send_button = tk.Button(master, text="Envoyer", command=self.send_message)
        self.send_button.pack(side=tk.RIGHT, padx=10)

        self.update_chat()

    def send_message(self):
        message = self.msg_entry.get()
        if message.strip():
            try:
                if self.chat_manager.send_message(self.user_id, self.other_user_id, message, self.ticket_id):
                    self.msg_entry.delete(0, tk.END)
                    self.update_chat()
                else:
                    messagebox.showerror("Erreur", "Échec de l'envoi du message.")
            except ValueError:
                messagebox.showerror("Erreur", "L'ID utilisateur doit être un entier.")

    def update_chat(self):
        self.chat_box.config(state=tk.NORMAL)
        self.chat_box.delete('1.0', tk.END)
        messages = self.chat_manager.get_ticket_messages(self.ticket_id)
        for msg in messages:
            expediteur = "Vous" if msg[1] == self.user_id else "Autre"
            self.chat_box.insert(tk.END, f"{expediteur}: {msg[0]} [{msg[3]}]\n")
        self.chat_box.config(state=tk.DISABLED)
        self.master.after(5000, self.update_chat)




    def open_chat_with_admin(self, admin_id):
        try:
            self.admin_id = int(admin_id)  # Store the admin_id as an attribute
            chat_window = tk.Toplevel(self.master)
            chat_view = ChatView(chat_window, self.user_id, self.admin_id, self.chat_manager)
            chat_window.mainloop()
        except ValueError:
            messagebox.showerror("Error", "Invalid admin ID. ID must be an integer.")
