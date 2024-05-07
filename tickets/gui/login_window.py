import tkinter as tk
from tkinter import messagebox
from .main_window import MainWindow

class LoginWindow:
    def __init__(self, master, user_manager, ticket_system, chat_manager, db_config):
        self.master = master
        self.user_manager = user_manager
        self.ticket_system = ticket_system
        self.chat_manager = chat_manager
        self.db_config = db_config  # Conservez uniquement la configuration de la base de données
        self.master.title("Login")

        self.frame = tk.Frame(self.master)
        self.label_email = tk.Label(self.frame, text="Email:")
        self.entry_email = tk.Entry(self.frame)

        self.label_password = tk.Label(self.frame, text="Password:")
        self.entry_password = tk.Entry(self.frame, show="*")

        self.login_button = tk.Button(self.frame, text="Login", command=self.login)
        self.quit_button = tk.Button(self.frame, text="Quit", command=self.master.quit)

        self.label_email.grid(row=0, column=0)
        self.entry_email.grid(row=0, column=1)
        self.label_password.grid(row=1, column=0)
        self.entry_password.grid(row=1, column=1)
        self.login_button.grid(row=2, column=1)
        self.quit_button.grid(row=2, column=0)
        self.frame.pack()

    def login(self):
        email = self.entry_email.get()
        password = self.entry_password.get()
        user = self.user_manager.validate_user(email, password)
        if user:
            self.master.withdraw()
            new_window = tk.Toplevel(self.master)
            # Initialisez MainWindow avec la configuration appropriée
            main_app = MainWindow(new_window, user, self.ticket_system, self.chat_manager, self.db_config)
        else:
            messagebox.showerror("Login failed", "Invalid credentials")
