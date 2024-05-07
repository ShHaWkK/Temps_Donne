import tkinter as tk
from tkinter import scrolledtext, simpledialog
from modules.chat_management import ChatManager  # Assurez-vous que ce chemin d'importation est correct

class ChatView:
    def __init__(self, master, user_info, db_config):
        self.master = master
        self.user_info = user_info
        self.db_config = db_config
        self.chat_manager = ChatManager(db_config)

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
            self.chat_manager.send_message(self.user_info['id'], message)
            self.msg_entry.delete(0, tk.END)
            self.update_messages()

    def update_messages(self):
        self.messages_frame.configure(state=tk.NORMAL)
        self.messages_frame.delete(1.0, tk.END)

        messages = self.chat_manager.get_messages(self.user_info['id'])
        for msg in messages:
            if msg['sender_id'] == self.user_info['id']:
                self.messages_frame.insert(tk.END, f"You: {msg['message']}\n", 'blue')
            else:
                self.messages_frame.insert(tk.END, f"Admin: {msg['message']}\n", 'red')

        self.messages_frame.configure(state=tk.DISABLED)
        self.master.after(5000, self.update_messages)  # Refresh messages every 5 seconds

    def display_chat_window(self):
        self.master.mainloop()