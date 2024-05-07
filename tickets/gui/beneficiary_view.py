import tkinter as tk

class BeneficiaryView:
    def __init__(self, master):
        self.master = master
        self.master.title("Beneficiary Dashboard")

        self.label = tk.Label(self.master, text="Beneficiary Dashboard", font=("Arial", 16))
        self.label.pack(pady=20)

        self.info_label = tk.Label(self.master, text="Welcome, Beneficiary! Here you can view available services and request help.", font=("Arial", 12))
        self.info_label.pack(pady=10)

        # Ajouter des éléments d'interface utilisateur pour afficher les services ou faire des requêtes.
