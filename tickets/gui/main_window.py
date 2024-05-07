from tkinter import Toplevel
from .admin_view import AdminView
from .volunteer_view import VolunteerView
from .beneficiary_view import BeneficiaryView

class MainWindow:
    def __init__(self, master, user):
        self.master = master
        self.user = user
        self.master.title("Main Window")

        if self.user['role'] == 'Administrateur':
            self.admin_view = AdminView(self.master)
        elif self.user['role'] == 'Benevole':
            self.volunteer_view = VolunteerView(self.master)
        elif self.user['role'] == 'Beneficiaire':
            self.beneficiary_view = BeneficiaryView(self.master)
