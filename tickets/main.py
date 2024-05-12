import tkinter as tk
from gui.login_window import LoginWindow
from modules.user_management import UserManager
from modules.ticket_system import TicketSystem
from modules.chat_management import ChatManager
from database_config import db_config

def main():
    root = tk.Tk()
    root.geometry("800x600")

    user_manager = UserManager(db_config)
    ticket_system = TicketSystem(db_config)
    chat_manager = ChatManager(db_config)
    # Passez db_config en tant qu'argument ici
    login_window = LoginWindow(root, user_manager, ticket_system, chat_manager, db_config)

    root.mainloop()

if __name__ == "__main__":
    main()


#'Doe', 'John', 'Homme', 'john.doe@example.com', 'hashed_password1', 'Administrateur'
 #  jane.smith@example.com hashed_password2', 'Benevole
# charlie.brown@example.com', 'hashed_password3', 'Beneficiaire'