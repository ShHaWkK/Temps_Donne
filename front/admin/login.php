<?php
include_once('../includes/lang.php');
include_once ('../includes/header.php');
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($data["LANGUAGE_CODE"]); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data["ADMIN_LOGIN_TITLE"]); ?> - Au temps donné</title>
    <link rel="stylesheet" href="../css/connexion.css">
</head>
<body>
<div class="container">
    <div class="left-side">
        <img src="../images/logo.png" alt="Logo de l'Association Au Temps Donné" class="logo">
        <h1 class="login-title"><?php echo htmlspecialchars($data["ADMIN_LOGIN_TITLE"]); ?></h1>
        <p class="login-subtitle"><?php echo htmlspecialchars($data["ADMIN_LOGIN_SUBTITLE"]); ?></p>
    </div>
    <div class="right-side">
        <form class="login-form" >
            <div class="input-group">
                <label for="email"><?php echo htmlspecialchars($data["ADMIN_EMAIL_INPUT_LABEL"]); ?>:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password"><?php echo htmlspecialchars($data["ADMIN_PASSWORD_INPUT_LABEL"]); ?>:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button id="validationButton" type="submit" class="login-button"><?php echo htmlspecialchars($data["ADMIN_LOGIN_BUTTON_TEXT"]); ?></button>
            <a href="forgot_password.php" class="forgot-password"><?php echo htmlspecialchars($data["ADMIN_FORGOT_PASSWORD_LINK"]); ?></a>
        </form>
    </div>
</div>

<script src="./js/login_admin.js"></script>
<?php
include_once('../includes/footer.php');
?>
</body>
</html>