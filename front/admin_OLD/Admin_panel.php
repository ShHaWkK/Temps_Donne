<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil de l'Administration</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    
<style>
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');
:root {
    --primary-color: #82CFD8; /* Primary color for the header and sidebar */
    --secondary-color: #00334A; /* Secondary color for buttons and table headers */
    --text-color: #000000; /* Main text color */
    --background-color: #FFFFFF; /* Main background color */
    --error-color: #ff4d4d; /* Color for error messages */
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html,body {
    font-family: 'Bebas Neue', sans-serif;
    width: 100%;
    height: 100%;
    background-color: var(--background-color);
    color: var(--text-color);
}

.sidebar {
    background-color: var(--primary-color); 
    min-height: 100vh;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    padding: 1rem;
    transition: width 0.3s;
}
.sidebar h2, .sidebar a {
    color: var(--background-color);
}

.menu a {
    display: block;
    padding: 0.5rem 1rem;
    text-decoration: none;
    transition: background-color 0.3s, color 0.3s;
}

.menu a:hover, .menu a.active {
    background-color: var(--secondary-color);
    color: var(--background-color);
}

.main-content {
    margin-left: 250px;
    padding: 1rem;
    background-color: var(--background-color);
}

.main-content header {
    background-color: var(--primary-color);
    color: var(--background-color);
    width: calc(100% - 250px); 
    position: fixed;
    top: 0;
    right: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    z-index: 10;
}

.search-bar input, .search-bar button {
    border: none;
    padding: 0.5rem;
}


.user-actions button {
    background-color: var(--secondary-color); 
    color: var(--background-color); 
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s; 
}

.user-actions button:hover {
    background-color: #001f2d;
    color: #ffffff; 
}


.welcome h1 {
    margin-bottom: 1rem;
}

.user-management-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
}

.users-table th, .users-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #ccc;
}

.users-table th {
    background-color: var(--secondary-color);
    color: var(--background-color);
}
.admin-name {
    font-size: 50px; 
    text-shadow: 2px 2px 4px #000000; 
}


button {
    background-color: var(--secondary-color);
    color: var(--background-color);
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #001f2d; 
}


.error-message {
    color: var(--error-color);
    margin: 1rem 0;
}
</style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <div class="profile-icon"></div>
            <?php echo "<p class='admin_OLD-name'>$adminNom $adminPrenom</p>"; ?>
    </div>
        <nav class="menu">
            <a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
            <a href="#stocks"><i class="fas fa-boxes"></i> Gestion des stocks</a>
            <a href="#services"><i class="fas fa-concierge-bell"></i> Gestion des services</a>
            <a href="#users"><i class="fas fa-users"></i> Gestion des utilisateurs</a>
            <a href="#roles"><i class="fas fa-user-tag"></i> Gestion des rôles</a>
            <a href="Captcha/list_capcha.php"<i class="fas fa-puzzle-piece"></i> Gestion des captchas</a>
        </nav>
        <form method="POST" style="margin-top: 20px;">
            <button type="submit" name="logout" class="btn btn-danger btn-block">Se déconnecter <i class="fa fa-sign-out"></i></button>
        </form>
    </div>
    <div class="main-content">
        <header>
            <div class="search-bar">
                <input type="search" placeholder="Recherche...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </div>
            <div class="user-actions">
                <button><i class="fas fa-envelope"></i></button>
                <button><i class="fas fa-bell"></i></button>
                <button><i class="fas fa-cog"></i></button>
            </div>
        </header>
        <main>
            <div class="welcome">
                <h1>BIENVENUE DANS L'ESPACE ADMINISTRATION</h1>
            </div>
            <section class="user-management">
                <div class="user-management-header">
                    <h2>UTILISATEURS:</h2>
                    <div class="user-actions">
                        <button><a href="users/admin_add_user.php">Ajouter un utilisateur</a></button>
                        <button>Ajouter un rôle</button>
                    </div>
                </div>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['Nom']; ?></td>
                                <td><?php echo $user['Prenom']; ?></td>
                                <td><?php echo $user['Email']; ?></td>
                                <td><?php echo $user['Role']; ?></td>                                
                                <td>
                                    <a href="users/edit_user.php?id=<?php echo $user['ID_Utilisateur']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Modifier</a>
                                    <a href="delete_user.php?id=<?php echo $user['ID_Utilisateur']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');"><i class="fas fa-trash-alt"></i> Supprimer</a>
                                    <a href="users/user_details.php?id=<?php echo $user['ID_Utilisateur']; ?>" class="btn btn-info"><i class="fas fa-info-circle"></i> Voir la fiche</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>


