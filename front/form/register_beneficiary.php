<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('../includes/header.php');
echo "<title>Inscription bénévole - Au temps donné</title>";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>

<div class="form-container">
    <div class="form-content">

        <div class="section">
            <h1> <?php echo htmlspecialchars($data["I_BECOME_BENEFICIARY"]);?> </h1>
            <p><?php echo htmlspecialchars($data["FORM_INTRO_BENEFICIARY"]);?>
            </p>
        </div>

        <div class="section">
            <h2> <?php echo htmlspecialchars($data["PERSONAL_INFORMATIONS"]);?> </h2>

            <div class="col">
                <h3> <?php echo htmlspecialchars($data["GENDER"]);?>: * </h3>
                <div class="line">
                    <label class="radio-label"> <?php echo htmlspecialchars($data["MALE"]);?> <input type="radio" id="genre" name="genre" value="homme" required> </label>
                    <label class="radio-label"> <?php echo htmlspecialchars($data["FEMALE"]);?> <input type="radio" id="genre" name="genre" value="femme" required> </label>
                    <label class="radio-label"> <?php echo htmlspecialchars($data["OTHER"]);?> <input type="radio" id="genre" name="genre" value="autre" required> </label>
                </div>
            </div>

            <div class="line">
                <div class="col">
                    <label for="nom"> <h3><?php echo htmlspecialchars($data["SURNAME"]);?>: *</h3></label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="col">
                    <label for="prenom"> <h3><?php echo htmlspecialchars($data["NAME"]);?>: *</h3></label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
            </div>

            <div class="col">
                <label for="date_naissance"><h3><?php echo htmlspecialchars($data["BIRTHDAY"]);?>: * </h3></label>
                <input type="date" id="date_naissance" name="date_naissance" required>
            </div>

            <div class="col">
                <label for="email"> <h3> <?php echo htmlspecialchars($data["EMAIL_LABEL"]);?>: * </h3> </label>
                <input type="email" id="email" name="email" required>
            </div>

            <!-- TODO vérifier si l'adresse mail existe-->
            <?php
            ?>

            <div class="col">
                <label for="telephone"><h3> <?php echo htmlspecialchars($data["PHONE_NUMBER"]);?>: * </h3></label>
                <input type="tel" id="telephone" name="telephone" required>
                <small class="format-info" color="red" >Format: 0123456789</small>
                </fieldset>
            </div>

            <div class="col">
                <label for="nationalite"><h3> <?php echo htmlspecialchars($data["NATIONALITY"]);?>: * </h3> </label>
                <select id="nationalite" name="nationalite" required>
                </select>
            </div>

            <div class="col">
                <label for="langues">
                    <h3><?php echo htmlspecialchars($data["LANGUAGES"]);?>: *</h3>
                </label>
                <h4><?php echo htmlspecialchars($data["LANGUAGES_EXPLAINATION_BENEFICIARY"]);?></h4>
                <select id="langues" name="langues[]" required multiple></select>
            </div>


            <div class="col">
                <h3> <?php echo htmlspecialchars($data["ADDRESS"]);?>: * </h3>
                <textarea id="name" name="name" rows="1" cols="1"></textarea>
            </div>

            <div class="line">
                <div class="col">
                    <label for="situation"> <h3> <?php echo htmlspecialchars($data["PERSONAL_SITUATION"]);?>: *</h3> </label>
                    <select id="situation" name="situation" required>
                        <option value="etudiant"><?php echo htmlspecialchars($data["STUDENT"]);?></option>
                        <option value="employe"><?php echo htmlspecialchars($data["EMPLOYED"]);?></option>
                        <option value="chomeur"><?php echo htmlspecialchars($data["UNEMPLOYED"]);?></option>
                        <option value="retraite"><?php echo htmlspecialchars($data["RETIRED"]);?></option>
                        <!-- Ajoutez d'autres options de situation personnelle ici -->
                    </select>
                </div>
            </div>
        </div>

        <div class="section">
            <h2> <?php echo htmlspecialchars($data["NEEDS AND EXPECTATIONS"]);?> </h2>

            <label for="services"> <h3> <?php echo htmlspecialchars($data["EXPECTED_SERVICES"]);?> *</h3><span class="services" multiple required></span></label>
            <select id="services" class="multiple" name="services[]" multiple >
                <option value="alphabetisation">Cours d'alphabetisation pour adulte </option>
                <option value="alphabetisation">Visite de personnes agées </option>
            </select>
        </div>

        <div class="section">
            <h2> <?php echo htmlspecialchars($data["TERMS_LEGAL_NOTICES"]);?> </h2>
            <div class="col">
                <label>
                    <?php echo htmlspecialchars($data["READ_ACCEPT"]);?> <a href="#" id="termsLink"> <?php echo htmlspecialchars($data["TERMS_LEGAL_NOTICES"]);?> *</a>
                    <input type="checkbox" id="légales" name="conditions" value="légales" required>
                </label>
            </div>

            <div class="col">
                <div id="termsModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <!-- Contenu des termes et conditions -->
                        <?php
                        $contenu = file_get_contents($data["CONDITIONS_PATH"]);

                        echo "<p>$contenu</p>";
                        ?>
                    </div>
                </div>
            </div>

            <div class="col">
                <label>
                    <?php echo htmlspecialchars($data["WISH_MAIL_NEWS"]);?>
                    <input type="checkbox" id="email_info" name="conditions" value="email_info">
                </label>
            </div>
            <div class="col">
                <p><?php echo htmlspecialchars($data["DEMANDS_CHECKED"]);?>.</p>
            </div>
        </div>

         <button class="confirm-button">Valider</button>
    </div> <!-- end of form-content -->
</div> <!-- end of form-container -->

<script src="../scripts/nationalities.js"></script>
<script src="../scripts/terms_and_conditions.js"></script>
<script src="../scripts/validate_required_fields.js"></script>
<script src="../scripts/languages.js"></script>

</body>

<?php
include_once('../includes/footer.php');
?>
</html>
