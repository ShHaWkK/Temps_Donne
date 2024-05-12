<?php
include_once('../includes/lang.php');
include_once('../includes/head.php');
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($userLanguage); ?>">
<head>
  <link rel="stylesheet" href="../css/connexion.css">
  <title><?php echo htmlspecialchars($data["BENEFICIARY_SPACE_TITLE"]); ?> - Au temps donné</title>
</head>

<body>
  <div class="container">
    <div class="left-side">
      <img src="../images/logo.png" alt="Logo" class="logo">
      <h1 class="login-title"><?php echo htmlspecialchars($data["BENEFICIARY_SPACE_TITLE"]); ?></h1>
      <p class="login-subtitle"><?php echo htmlspecialchars($data["BENEFICIARY_SPACE_SUBTITLE"]); ?></p>
      <div class="register">
        <span><?php echo htmlspecialchars($data["NEW_HERE"]); ?></span>
          <a href="../form/register_beneficiary.php" class="register-button"><?php echo htmlspecialchars($data["CREATE_ACCOUNT"]); ?></a>
      </div>
    </div>
    <div class="right-side">
      <form class="login-form">
        <div class="input-group">
          <label for="email"><?php echo htmlspecialchars($data["EMAIL_LABEL"]); ?></label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="input-group">
          <label for="password"><?php echo htmlspecialchars($data["PASSWORD_LABEL"]); ?></label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="login-button"><?php echo htmlspecialchars($data["LOGIN_BUTTON"]); ?></button>
        <a href="#" class="forgot-password"><?php echo htmlspecialchars($data["FORGOT_PASSWORD"]); ?></a>
      </form>
    </div>
  </div>

  <script src="../scripts/api_integration/login_volunteer.js"></script>

</body>
</html>
