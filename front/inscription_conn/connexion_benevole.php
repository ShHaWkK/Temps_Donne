<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/connexion.css">
  <title>Connexion Bénévole</title>
</head>
<body>
  <div class="container">
    <div class="left-side">
      <img src="../images/logo.png" alt="Logo de l'Association Au Temps Donné" class="logo"><h1 class="login-title">ESPACE BÉNÉVOLE</h1>
      <p class="login-subtitle">Ensemble, faisons la différence</p>
      <div class="register">
        <span>Pas de compte bénévole ?</span>
        <button class="register-button">Je m'engage</button>
      </div>
    </div>
    <div class="right-side">
      <form class="login-form">
        <div class="input-group">
          <label for="username">Nom d'utilisateur:</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
          <label for="password">Mot de passe:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="login-button">S'identifier</button>
        <a href="#" class="forgot-password">Mot de passe oublié ?</a>
      </form>
    </div>
  </div>
</body>
</html>
