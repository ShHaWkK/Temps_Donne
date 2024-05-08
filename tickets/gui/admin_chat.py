import tkinter as tk
from tkinter import scrolledtext, messagebox

class AdminChatView:
    def __init__(self, master, ticket_id, chat_manager):
        self.master = master
        self.ticket_id = ticket_id
        self.chat_manager = chat_manager

        self.master.title(f"Chat pour le ticket - ID: {ticket_id}")
        self.master.geometry("400x400")

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
            if self.chat_manager.send_admin_message(self.ticket_id, message):
                self.msg_entry.delete(0, tk.END)
                self.update_chat()
            else:
                messagebox.showerror("Erreur", "Échec de l'envoi du message.")

    def update_chat(self):
        self.chat_box.config(state='normal')
        self.chat_box.delete('1.0', tk.END)

        messages = self.chat_manager.get_ticket_messages(self.ticket_id)
        for msg in messages:
            expediteur = f"Utilisateur {msg[1]}" if msg[1] else "Admin"
            destinataire = f"Utilisateur {msg[2]}" if msg[2] else "Tous"
            self.chat_box.insert(tk.END, f"{expediteur} à {destinataire} : {msg[0]} [{msg[3]}]\n")

        self.chat_box.yview(tk.END)
        self.chat_box.config(state='disabled')
