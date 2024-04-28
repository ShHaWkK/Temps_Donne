class User:
    def __init__(self, id, email, password, roles=[]):
        self.id = id
        self.email = email
        self.password = password  # Should be hashed in a real application
        self.roles = roles

class Role:
    def __init__(self, id, name):
        self.id = id
        self.name = name

class Ticket:
    def __init__(self, id, title, description, status, priority, creator_id, assignee_id):
        self.id = id
        self.title = title
        self.description = description
        self.status = status
        self.priority = priority
        self.creator_id = creator_id
        self.assignee_id = assignee_id
