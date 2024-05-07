import tkinter as tk

class AdminView:
    def __init__(self, master):
        self.master = master
        self.master.title("Admin Dashboard")

        self.frame = tk.Frame(self.master)
        self.label = tk.Label(self.frame, text="Welcome to the Admin Dashboard")
        self.label.pack()
        self.frame.pack()
