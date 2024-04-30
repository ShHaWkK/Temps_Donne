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

<div class="form-container">
    <div class="form-content">
        <div class="section">
            <h1><?php echo htmlspecialchars($data["I_BECOME_VOLUNTEER"] ?? 'I become volunteer');?></h1>
            <p><?php echo htmlspecialchars($data["FORM_INTRO_VOLUNTEER"]);?>
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
                <label for="mot_de_passe"> <h3> <?php echo htmlspecialchars($data["PASSWORD_LABEL"]);?>: *</h3></label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

<!--
            <div class="col">
                <label for="langues">
                    <h3><?php echo htmlspecialchars($data["LANGUAGES"]);?>: *</h3>
                </label>
                <h4><?php echo htmlspecialchars($data["LANGUAGES_EXPLAINATION"]);?></h4>
                <select id="langues" name="langues[]" required multiple></select>
            </div>
-->

            <div class="col">
                <h3> <?php echo htmlspecialchars($data["ADDRESS"]);?>: * </h3>
                <textarea id="adresse" name="adresse" rows="1" cols="1"></textarea>
            </div>

            <div class="line">
                <div class="col">
                    <label for="situation"> <h3> <?php echo htmlspecialchars($data["PERSONAL_SITUATION"]);?>: *</h3> </label>
                    <select id="situation" name="situation" required>
                        <option value="Etudiant"><?php echo htmlspecialchars($data["STUDENT"]);?></option>
                        <option value="Employe"><?php echo htmlspecialchars($data["EMPLOYED"]);?></option>
                        <option value="Chomeur"><?php echo htmlspecialchars($data["UNEMPLOYED"]);?></option>
                        <option value="Retraite"><?php echo htmlspecialchars($data["RETIRED"]);?></option>
                        <!-- Ajoutez d'autres options de situation personnelle ici -->
                    </select>
                </div>
            </div>
        </div>

        <div class="section" >
            <h2> <?php echo htmlspecialchars($data["AVAILABILITY_INTERVENTION_AREA"]);?> </h2>
            <h3><?php echo htmlspecialchars($data["MOBILITY"]);?>: *</h3>
            <div class="col">
                <div class="line permis">
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                    <a><?php echo htmlspecialchars($data["DRIVER_LICENSE"]);?></a>
                </div>
                <div class="line permis">
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                    <a><?php echo htmlspecialchars($data["HEAVY_LICENSE"]);?></a>
                </div>
                <div class="line permis">
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                    <a>CACES</a>
                </div>
            </div>
            <div class="col">
                <h3><?php echo htmlspecialchars($data["SUPPORTING_DOCUMENTS"]);?>: *</h3>
                <form action="upload.php" method="post" enctype="multipart/form-data" required>
                    <label for="permis_file"><?php echo htmlspecialchars($data["SEND_LICENSE"]);?> : <br></label>
                    <input type="file" id="permis_file" name="permis" accept=".pdf">
                </form>
            </div>

            <div class="col">
                <h3><?php echo htmlspecialchars($data["EXPERIENCE"]);?>: </h3>
                <form action="upload.php" method="post" enctype="multipart/form-data" required>
                    <label for="CV"> <?php echo htmlspecialchars($data["SEND_RESUME"]);?> : <br></label>
                    <input type="file" id="CV" name="CV" accept=".pdf">
                </form>
            </div>

            <div class="col">
                <h3><?php echo htmlspecialchars($data["AVAILABILITY"]);?>: </h3>
                <div class="line">
                    <label class="radio-label"> <?php echo htmlspecialchars($data["REGULAR_AVAILABILITY"]);?> <input type="radio" name="disponibilite" value="reguliere" required> </label>
                    <label class="radio-label"> <?php echo htmlspecialchars($data["PUNCTUAL_AVAILABILITY"]);?> <input type="radio" name="disponibilite" value="ponctuelle" required> </label>
                </div>
            </div>

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
            </div>

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

        <button id="validationButton" class="btn confirm-button"><?php echo htmlspecialchars($data["CONFIRM"]);?></button>
    </div> <!-- end of form-content -->
</div> <!-- end of form-container -->

<script src="../scripts/nationalities.js"></script>
<script src="../scripts/terms_and_conditions.js"></script>
<script src="../scripts/validate_required_fields.js"></script>
<script src="../scripts/languages.js"></script>
<script src="../scripts/api_integration/register_volunteer.js"></script>

</body>

<?php
include_once('../includes/footer.php');
?>
</html>