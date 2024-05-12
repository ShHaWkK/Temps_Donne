<?php
if (file_exists('../includes/lang.php')) {
    include_once('../includes/lang.php');
} else {
}
$data = $data ?? []; 

?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($data['LANGUAGE_CODE']); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($data['COOKIE_TITLE']) ? htmlspecialchars($data['COOKIE_TITLE']) : 'Default Title'; ?></title>
    <link rel="stylesheet" href="../css/cookie.css">
</head>
<body>

<div class="cookie-wrapper">
        <div class="titre">
            <i class="bx bx-cookie"></i>
            <img src="images/cookie.png" alt="Cookie Icon" class="header-image">
            <h2><?php echo !empty($data['COOKIE_TITLE']) ? htmlspecialchars($data['COOKIE_TITLE']) : 'Cookies'; ?></h2>
        </div>
        <div class="data">
            <p><?php echo !empty($data['COOKIE_DESCRIPTION']) ? htmlspecialchars($data['COOKIE_DESCRIPTION']) : 'When you visit our website, we may access some of your information to better guide you and make tasks easier on our site. To learn more:'; ?> 
            <a href="<?php echo !empty($data['COOKIE_POLICY_LINK']) ? htmlspecialchars($data['COOKIE_POLICY_LINK']) : '#'; ?>">
            <?php echo !empty($data['COOKIE_POLICY_TEXT']) ? htmlspecialchars($data['COOKIE_POLICY_TEXT']) : 'Cookie Policy'; ?></a></p>
        </div>
        <div class="choisir">
            <button class="choix" id="acceptBtn"><?php echo !empty($data['ACCEPT_BUTTON']) ? htmlspecialchars($data['ACCEPT_BUTTON']) : 'Accept'; ?></button>
            <button class="choix" id="declineBtn"><?php echo !empty($data['DECLINE_BUTTON']) ? htmlspecialchars($data['DECLINE_BUTTON']) : 'Decline'; ?></button>
        </div>
    </div>

    <script>
    const cookieBox = document.querySelector(".cookie-wrapper"),
          acceptBtn = document.getElementById("acceptBtn"),
          declineBtn = document.getElementById("declineBtn");

    const executeCodes = () => {
        if (document.cookie.includes("AuTempsDonnee")) return;
        cookieBox.classList.add("show");

        acceptBtn.addEventListener("click", () => {
            cookieBox.classList.remove("show");
            //document.cookie = "cookieBy=AuTempsDonnee; max-age=" + 60 * 60 * 24 * 30; // Sets the cookie for 1 month
            // 1 seconde 
            document.cookie = "cookie = AuTempsDonnee; max-age=" + 1;
        });

        declineBtn.addEventListener("click", () => {
            cookieBox.classList.remove("show");
        });
    };
    window.addEventListener("load", executeCodes);
    </script>

</body>
</html>
