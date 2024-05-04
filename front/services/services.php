<?php
ob_start(); // Commence la mise en tampon de sortie
include_once('../includes/head.php');
include_once('../includes/header.php');
include_once('../includes/lang.php');
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/services.css">
    <title><?php echo htmlspecialchars($data["OUR_SERVICES"]); ?></title>
</head>

<body>


<div class="main-container shade">
    <h1><?php echo htmlspecialchars($data["OUR_SERVICES"]); ?></h1>
    <div class="service-list">
        <button class="service-button">
            <h3><?php echo htmlspecialchars($data["FOOD_DISTRIBUTION"]); ?></h3>
            <img src="../images/icones/meal.png" alt="<?php echo htmlspecialchars($data["FOOD_DISTRIBUTION_ALT"]); ?>" width="100" height="100">
        </button>
        <button class="service-button">
            <h3><?php echo htmlspecialchars($data["ADMINISTRATIVE_SERVICES"]); ?></h3>
            <img src="../images/icones/budget.png" alt="<?php echo htmlspecialchars($data["ADMINISTRATIVE_SERVICES_ALT"]); ?>" width="100" height="100">
        </button>
        <button class="service-button">
            <h3><?php echo htmlspecialchars($data["SHUTTLE_SERVICES"]); ?></h3>
            <img src="../images/icones/shuttle.png" alt="<?php echo htmlspecialchars($data["SHUTTLE_SERVICES_ALT"]); ?>" width="100" height="100">
        </button>
        <button class="service-button">
            <h3><?php echo htmlspecialchars($data["LITERACY_COURSES"]); ?></h3>
            <img src="../images/icones/readAdult.png" alt="<?php echo htmlspecialchars($data["LITERACY_COURSES_ALT"]); ?>" width="100" height="100">
        </button>
        <button class="service-button">
            <h3><?php echo htmlspecialchars($data["ACADEMIC_SUPPORT"]); ?></h3>
            <img src="../images/icones/read.png" alt="<?php echo htmlspecialchars($data["ACADEMIC_SUPPORT_ALT"]); ?>" width="100" height="100">
        </button>
        <!-- Uncomment or add new service buttons as needed -->
        <button class="service-button">
            <h3><?php echo htmlspecialchars($data["FUNDRAISING_EVENTS"]); ?></h3>
            <img src="../images/icones/donate.png" alt="<?php  echo htmlspecialchars($data["FUNDRAISING_EVENTS_ALT"]); ?>" width="100" height="100">
        </button>
        <button class="service-button">
            <h3><?php echo htmlspecialchars($data["ACTIVITIES_FOR_ELDERLY"]); ?></h3>
            <img src="../images/icones/couple.png" alt="<?php echo htmlspecialchars($data["ACTIVITIES_FOR_ELDERLY_ALT"]); ?>" width="100" height="100">
        </button>
    </div>
</div>
</body>

</html>