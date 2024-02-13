<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../BDD/Connection.php');

$error_message = '';

if (isset($_POST['submit'])) {
    if (isset($_POST['adminEmail']) && isset($_POST['password'])) {
        $adminEmail = $_POST['adminEmail'];
        $password = $_POST['password'];

        $stmt = $conn->prepare('SELECT * FROM Administrateurs WHERE email = :email');
        $stmt->execute(array('email' => $adminEmail));

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // vérification du mot de passe
            if (password_verify($password, $row['Mot_de_passe'])) {
                $_SESSION['admin'] = $row['Nom']; 
                header('Location: Admin_Panel.php'); 
                exit();
            } else {
                $error_message = 'Mot de passe incorrect';
            }
        } else {
            $error_message = 'Adresse e-mail non trouvée';
        }
    }
}
?>
<body>
    <div class="login-form">
        <h2>Connexion Admin</h2>
        <?php if (isset($error_message) && !empty($error_message)): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="email" name="adminEmail" placeholder="Adresse e-mail">
            </div>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Mot de passe">
            </div>

            <button type="submit" name="submit">Me connecter</button>
            
        </form>
    </div>
</body>
</html>
