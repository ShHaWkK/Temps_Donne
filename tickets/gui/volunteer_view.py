import tkinter as tk

class VolunteerView:
    def __init__(self, master):
        self.master = master
        self.master.title("Volunteer Dashboard")

        self.label = tk.Label(self.master, text="Volunteer Dashboard", font=("Arial", 16))
        self.label.pack(pady=20)

        self.info_label = tk.Label(self.master, text="Welcome, Volunteer! Here you can manage your activities.", font=("Arial", 12))
        self.info_label.pack(pady=10)

        # Ici, vous pouvez ajouter plus de widgets comme des boutons, des listes, etc.
