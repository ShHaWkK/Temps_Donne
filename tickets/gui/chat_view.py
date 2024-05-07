import tkinter as tk
from tkinter import scrolledtext, simpledialog
from modules.chat_management import ChatManager

class ChatView:
    def __init__(self, master, user_info, admin_id, chat_manager, db_config):
        self.master = master
        self.user_info = user_info
        self.admin_id = admin_id
        self.chat_manager = chat_manager
        self.db_config = db_config

        self.master.title("Chat")

        self.messages_frame = scrolledtext.ScrolledText(master, wrap=tk.WORD, width=50, height=10, font=("Arial", 10))
        self.messages_frame.pack(padx=20, pady=10)

        self.msg_entry = tk.Entry(master, width=40)
        self.msg_entry.pack(side=tk.LEFT, padx=10)
        self.send_button = tk.Button(master, text="Send", command=self.send_message)
        self.send_button.pack(side=tk.RIGHT, padx=10)

        self.update_messages()

    def send_message(self):
        message = self.msg_entry.get()
        if message:
            # Assurez-vous que self.user_info contient l'identifiant de l'utilisateur
            user_id = self.user_info if isinstance(self.user_info, int) else self.user_info.get('id')
            if user_id is not None:
                try:
                    receiver_id = int(self.admin_id)  # Convertit en entier
                    self.chat_manager.send_message(user_id, receiver_id, message)
                    self.msg_entry.delete(0, tk.END)
                    self.update_messages()
                except ValueError:
                    print("Erreur: ID du destinataire invalide.")
                    # Gérer l'erreur ici, par exemple, afficher un message à l'utilisateur
            else:
                print("Erreur: ID de l'utilisateur invalide.")
                # Gérer l'erreur ici, par exemple, afficher un message à l'utilisateur

    def update_messages(self):
        self.messages_frame.configure(state=tk.NORMAL)
        self.messages_frame.delete(1.0, tk.END)

        user_id = self.user_info if isinstance(self.user_info, int) else self.user_info.get('id')
        if user_id is not None:
            messages = self.chat_manager.get_messages(user_id)
            for msg in messages:
                if msg['sender_id'] == user_id:
                    self.messages_frame.insert(tk.END, f"You: {msg['message']}\n", 'blue')
                else:
                    self.messages_frame.insert(tk.END, f"Admin: {msg['message']}\n", 'red')

        self.messages_frame.configure(state=tk.DISABLED)
        self.master.after(5000, self.update_messages)

    def display_chat_window(self):
        self.master.mainloop()
