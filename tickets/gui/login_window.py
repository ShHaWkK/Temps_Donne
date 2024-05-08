import tkinter as tk
from tkinter import ttk, messagebox
from .main_window import MainWindow

class LoginWindow:
    def __init__(self, master, user_manager, ticket_system, chat_manager, db_config):
        self.master = master
        self.user_manager = user_manager
        self.ticket_system = ticket_system
        self.chat_manager = chat_manager
        self.db_config = db_config
        self.master.title("Connexion")

        # Couleurs
        self.bg_color = "#f0f0f0"
        self.primary_color = "#4CAF50"
        self.secondary_color = "#2196F3"
        self.text_color = "#333333"

        # Cadre principal
        self.main_frame = tk.Frame(self.master, bg=self.bg_color)
        self.main_frame.pack(fill=tk.BOTH, expand=True)

        # En-tête
        self.header_frame = tk.Frame(self.main_frame, bg=self.primary_color)
        self.header_frame.pack(fill=tk.X)
        self.header_label = tk.Label(self.header_frame, text="Login", font=("Arial", 18), fg="white", bg=self.primary_color)
        self.header_label.pack(pady=10)

        # Cadre du formulaire
        self.form_frame = tk.Frame(self.main_frame, bg=self.bg_color)
        self.form_frame.pack(fill=tk.BOTH, expand=True, padx=20, pady=20)

        self.label_email = tk.Label(self.form_frame, text="Email:", fg=self.text_color, bg=self.bg_color)
        self.label_email.grid(row=0, column=0, padx=10, pady=10)
        self.entry_email = tk.Entry(self.form_frame, font=("Arial", 12))
        self.entry_email.grid(row=0, column=1, padx=10, pady=10)

        self.label_password = tk.Label(self.form_frame, text="Password:", fg=self.text_color, bg=self.bg_color)
        self.label_password.grid(row=1, column=0, padx=10, pady=10)
        self.entry_password = tk.Entry(self.form_frame, show="*", font=("Arial", 12))
        self.entry_password.grid(row=1, column=1, padx=10, pady=10)

        self.login_button = tk.Button(self.form_frame, text="Login", command=self.login, bg=self.secondary_color, fg="white", padx=10, pady=5)
        self.login_button.grid(row=2, column=1, padx=10, pady=10)

        self.quit_button = tk.Button(self.form_frame, text="Quit", command=self.master.quit, bg=self.text_color, fg="white", padx=10, pady=5)
        self.quit_button.grid(row=2, column=0, padx=10, pady=10)

    def login(self):
        email = self.entry_email.get()
        password = self.entry_password.get()
        user = self.user_manager.validate_user(email, password)
        if user:
            self.master.withdraw()
            new_window = tk.Toplevel(self.master)
            main_app = MainWindow(new_window, user, self.ticket_system, self.chat_manager, self.db_config)
        else:
            messagebox.showerror("Login failed", "Invalid credentials")
