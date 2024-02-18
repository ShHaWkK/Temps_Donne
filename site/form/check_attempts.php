<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('Connection.php');

function checkTentatives($conn, $ip) {
    $maxTentatives = 5; 
    $blocageMinutes = 30; 

    $stmt = $conn->prepare("SELECT * FROM tentatives_connexion WHERE ip_adresse = :ip");
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $tentatives = $result['tentative_count'];
        $lastAttempt = strtotime($result['last_attempt']);
        $tempsEcoule = time() - $lastAttempt;

        if ($tentatives >= $maxTentatives && $tempsEcoule < $blocageMinutes * 60) {
            return false;
        } else if ($tempsEcoule > $blocageMinutes * 60) {
            resetTentatives($conn, $ip);
        }
    }

    return true;
}

function incrementTentative($conn, $ip) {
    $stmt = $conn->prepare("INSERT INTO tentatives_connexion (ip_adresse, tentative_count, last_attempt) VALUES (:ip, 1, NOW()) ON DUPLICATE KEY UPDATE tentative_count = tentative_count + 1, last_attempt = NOW()");
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();
}

function resetTentatives($conn, $ip) {
    $stmt = $conn->prepare("UPDATE tentatives_connexion SET tentative_count = 0, last_attempt = NOW() WHERE ip_adresse = :ip");
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();
}

$ipAdresse = $_SERVER['REMOTE_ADDR'];

if (checkTentatives($conn, $ipAdresse)) {
    // Logique de traitement de l'inscription
    // Pensez à l'algorithme 
    incrementTentative($conn, $ipAdresse);
} else {
    echo "Trop de tentatives échouées. Veuillez réessayer plus tard.";
    exit;
}
?>
