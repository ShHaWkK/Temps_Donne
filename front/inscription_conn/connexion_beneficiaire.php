<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/connexion.css">
  <title>Connexion Bénéficiaire</title>
</head>
<body>
  <div class="container">
    <div class="left-side">
      <img src="../images/logo.png" alt="Logo des Bénéficiaires" class="logo">
      <h1 class="login-title">ESPACE BÉNÉFICIAIRE</h1>
      <p class="login-subtitle">Votre engagement, notre force</p>
      <div class="register">
        <span>Nouveau ici ?</span>
        <button class="register-button">Créer un compte</button>
      </div>
    </div>
    <div class="right-side">
      <form class="login-form">
        <div class="input-group">
          <label for="email">E-mail:</label>
          <input type="email" id="email" name="email" required>
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
