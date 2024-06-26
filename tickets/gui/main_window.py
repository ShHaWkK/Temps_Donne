# gui/main_window.py
import tkinter as tk
import mysql.connector
from gui.admin_view import AdminView
from gui.volunteer_view import VolunteerView
from gui.beneficiary_view import BeneficiaryView

class MainWindow:
    def __init__(self, master, user, ticket_system, chat_manager, db_config):
        self.master = master
        self.user = user
        self.ticket_system = ticket_system
        self.chat_manager = chat_manager
        self.db_config = db_config

        self.master.title("Main Window")

        # Établir une connexion à la base de données
        self.db_connection = mysql.connector.connect(**self.db_config)
        self.db_cursor = self.db_connection.cursor()

        if self.user['role'] == 'Administrateur':
            self.admin_view = AdminView(self.master, self.ticket_system, self.chat_manager, self.db_config, self.user['id'])
        elif self.user['role'] == 'Benevole':
            self.volunteer_view = VolunteerView(self.master, self.user['id'], self.ticket_system, self.chat_manager, self.db_config)
        elif self.user['role'] == 'Beneficiaire':
            self.beneficiary_view = BeneficiaryView(self.master, self.user['id'], self.ticket_system, self.chat_manager)
