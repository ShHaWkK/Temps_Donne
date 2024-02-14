<?php
session_start();

// Vérification
if(!isset($_SESSION['admin'])){
    header('Location: Admin_login.php'); 
    exit();
}

include('BDD/Connection.php'); 



// Déconnecter l'administrateur
if(isset($_POST['logout'])){
    unset($_SESSION['admin']);
    header('Location: Admin_login.php');
    exit();
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Espace d'Administration</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="admin-container">
        <div id="sidebar-menu">
            <ul>
                <li><a href="#users" class="list-group-item list-group-item-action"><i class="fa fa-users mr-2"></i>Tous les utilisateurs</a></li>
                <li><a href="gestion_stocks.php">Gestion des Stocks</a></li>
                <li><a href="gestion_services.php">Gestion des Services</a></li>
                <li><a href="gestion_benevoles.php">Gestion des Bénévoles</a></li>
                <li><a href="gestion_activites.php">Gestion des Activités</a></li>
                <li><a href="gestion_tickets.php">Gestion des Tickets</a></li>
                <li><a href="Captcha/list_capcha.php" class="list-group-item list-group-item-action"><i class="fa fa-envelope mr-2"></i>Captcha</a></li>
                <li><a href="Admin_login.php" class="list-group-item list-group-item-action"><i class="fa fa-sign-out mr-2"></i>Déconnexion</a></li>
            </ul>
            <form method="POST" style="margin-top: 20px;">
                    <button type="submit" name="logout" class="btn btn-danger btn-block">Se déconnecter <i class="fa fa-sign-out"></i></button>
                </form>
        </div>
        
        <div id="main-content">
            <h1>Tableau de Bord</h1>
            <div class="dashboard">
                <div class="dashboard-item">
                    <h2>Statistiques Rapides</h2>
                    <!-- Ici, insérez des statistiques comme le nombre de bénévoles, le nombre d'événements à venir, etc. -->
                </div>
                <div class="dashboard-item">
                    <h2>Notifications Récentes</h2>
                    <!-- z les dernières notifications ou alertes -->
                </div>
                <div class="dashboard-item">
                    <h2>Activités Récentes</h2>
                    <!-- Un aperçu des activités ou des tâches récentes -->
                </div>
                 <!-- Section Ticketing -->
                 <div class="dashboard-item">
                    <h2>Tickets Récent</h2>
                    <!-- Affichez un aperçu des derniers tickets -->
                </div>
                <div class="dashboard-item">
                    <h2>Calendrier des Événements</h2>
                    <!-- Calendrier ou liste des prochains événements -->
                </div>
                <div class="dashboard-item">
                    <h2>Rappels Importants</h2>
                    <!-- Liste des rappels ou des tâches urgentes -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
