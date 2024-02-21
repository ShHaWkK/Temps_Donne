<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion Espace Bénévole</title>
<style>
  /* Layout Styles */
  body, html {
    margin: 0;
    height: 100%;
    font-family: 'Arial', sans-serif;
    background-color: #E5E5E5;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .container {
    display: flex;
    width: 100%; /* Adjust width as necessary */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
  }

  .left-panel {
    background-color: #82CFD8;
    color: #005F7A;
    padding: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 130%;
  }

  .logo-container img {
    width: 100px; /* Adjust based on actual logo size */
    margin-bottom: 20px;
  }

  .left-panel h1 {
    margin-bottom: 10px;
  }

  .engage-button {
    background-color: #007FA9;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    margin-top: 20px; /* Adjust spacing as needed */
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
  }

  .right-panel {
    background-color: white;
    padding: 35px;
    width: 60%;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  /* Form Styles */
  .login-form label {
    display: block;
    margin-bottom: 5px;
  }

  .login-form input {
    width: 100%;
    margin-bottom: 15px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .login-button {
    background-color: #007FA9;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
  }

  .login-button:hover {
    background-color: #005f7a;
  }

  .forgot-password {
    display: block;
    color: #007FA9;
    text-decoration: none;
    text-align: right;
    margin-top: 10px;
  }

  /* Responsive Styles */
  @media (max-width: 800px) {
    .container {
      flex-direction: column;
      width: 90%;
    }

    .left-panel, .right-panel {
      width: 100%;
      padding: 20px;
    }
  }

</style>
</head>
<body>
<div class="container">
  <div class="left-panel">
    <div class="logo-container">
      <!-- Insert your actual logo image file here -->
      <img src="../images/logo.png" alt="Logo de l'association" />
    </div>
    <h1>ESPACE BÉNÉVOLE</h1>
    <p>ENSEMBLE, FAISONS LA DIFFÉRENCE</p>
    <p>PAS DE COMPTE BÉNÉVOLE ! </p><a href="#" class="engage-button">JE M'ENGAGE</a>
  </div>
  <div class="right-panel">
    <form class="login-form">
      <label for="username">Nom d'utilisateur:</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Mot de passe:</label>
      <input type="password" id="password" name="password" required>
      <button type="submit" class="login-button">S'identifier</button>
      <a href="#" class="forgot-password">Mot de passe oublié ?</a>
    </form>
  </div>
</div>
</body>
</html>
