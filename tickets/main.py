import tkinter as tk
from gui.login_window import LoginWindow
from modules.user_management import UserManager
from database_config import db_config
import sys
import os

sys.path.append(os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))

def main():
    root = tk.Tk()
    root.geometry("800x600")

    user_manager = UserManager(db_config)
    login_window = LoginWindow(root, user_manager)

    root.mainloop()


if __name__ == "__main__":
    main()
