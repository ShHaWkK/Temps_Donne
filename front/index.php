<?php
session_start();
include_once('includes/lang.php');
include_once('includes/head.php');
include_once('includes/header.php');
echo "<title>Accueil - Au temps donné</title>";
?>

<body>
  
<div class="carousel-container">
    <button class="carousel-arrow">&lt;</button>
    <div class="carousel-caption">
      <h1><?php echo htmlspecialchars($data["WELCOME"] ?? 'Default Welcome Message');?></h1>
      <center>
         <?php echo htmlspecialchars($data["BECOME_VOLUNTEER"] ?? 'Become a volunteer today!'); ?>
      </center>
      <button><?php echo htmlspecialchars($data["JOIN_NOW"] ?? 'Join now!'); ?></button>
    </div>
    <button class="carousel-arrow">&gt;</button>
</div>


  <div class="section">
    <div class="section-title"><?php echo htmlspecialchars($data["WHO_WE_ARE_TITLE"]); ?></div>
    <p class="section-content"><?php echo htmlspecialchars($data["WHO_WE_ARE_CONTENT"]); ?></p>
    <button class="section-button"><i class="fa-solid fa-house"></i> <?php echo htmlspecialchars($data["DISCOVER_OUR_SERVICES"]); ?></button>
</div>

<div class="location-section">
    <h2 class="location-title"><?php echo htmlspecialchars($data["FIND_US_TITLE"]); ?></h2>
    <p class="location-text"><?php echo htmlspecialchars($data["FIND_US_CONTENT"]); ?></p>
    <i class="fas fa-map-marker-alt location-icon"></i>
</div>

<div class="section">
    <div class="section-title"><?php echo htmlspecialchars($data["HOW_TO_HELP_TITLE"]); ?></div>
    <p class="section-content"><?php echo htmlspecialchars($data["HOW_TO_HELP_CONTENT"]); ?></p>
    <button class="section-button"><i class="fa-solid fa-hand-holding-heart"></i> <?php echo htmlspecialchars($data["MAKE_A_DONATION"]); ?></button>
</div>

  <?php
  include_once('includes/cookie.php');
  include_once('includes/footer.php');
  ?>

</body>
<script>
function changeLanguage(lang) {
    window.location.href = window.location.pathname + "?lang=" + lang;
}
</script>
</html>