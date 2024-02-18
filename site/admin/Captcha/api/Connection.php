<?php

$servername = "localhost";
$dbname = "au_temps_donnee"; 
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connexion échouée : " . $e->getMessage();
}
?>