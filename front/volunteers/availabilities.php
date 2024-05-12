<?php
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
echo "<title>Espace bénévole - Planning</title>";
?>

<div class="main-container">

    <h1>Mes disponibilités</h1>

    <div class="col-availability">
        <div class="line">
            <h4><?php echo htmlspecialchars($data["I_CAN_DEVOTE"]);?> : </h4>
            <select class="heures" id="heures" name="heures" required>
                <option value="1">1 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="2">2 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="3">3 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="4">4 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="5">5 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="6">6 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="7">7 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="8">8 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="9">9 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="10">10 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="11">11 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="12">12 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="13">13 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
                <option value="14">14 <?php echo htmlspecialchars($data["HALF_DAY"]);?></option>
            </select>
            <h4> <?php echo htmlspecialchars($data["PER_WEEK_VOLUNTEER_MISSIONS"]);?> <br> </h4>
        </div>

        <div class="col-week">
            <label><input type="checkbox" id="lundi" name="jour" value="lundi"> <?php echo htmlspecialchars($data["MONDAY"]);?></label><br>
            <label><input type="checkbox" id="mardi" name="jour" value="mardi"> <?php echo htmlspecialchars($data["TUESDAY"]);?></label><br>
            <label><input type="checkbox" id="mercredi" name="jour" value="mercredi"> <?php echo htmlspecialchars($data["WEDNESDAY"]);?></label><br>
            <label><input type="checkbox" id="jeudi" name="jour" value="jeudi"> <?php echo htmlspecialchars($data["THURSDAY"]);?></label><br>

            <label><input type="checkbox" id="vendredi" name="jour" value="vendredi"> <?php echo htmlspecialchars($data["FRIDAY"]);?></label><br>
            <label><input type="checkbox" id="samedi" name="jour" value="samedi"> <?php echo htmlspecialchars($data["SATURDAY"]);?></label><br>
            <label><input type="checkbox" id="dimanche" name="jour" value="dimanche"> <?php echo htmlspecialchars($data["SUNDAY"]);?></label><br>
        </div>

        <button id="validationButton" class="btn confirm-button">Modifier mes disponibilités actuelles</button>
    </div>


    <script src="../scripts/checkSession.js"></script>
    <script src="../scripts/getCookie.js"></script>