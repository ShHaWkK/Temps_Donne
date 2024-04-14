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

</div>

<div class="form-container">
    <div class="form-content">
        <h1><?php echo htmlspecialchars($data["I_BECOME_VOLUNTEER"] ?? 'I become volunteer');?></h1>
        <p><?php echo htmlspecialchars($data["FORM_INTRO_VOLUNTEER"]);?>
        </p>
        <h2> <?php echo htmlspecialchars($data["PERSONAL_INFORMATIONS"]);?> </h2>
        <h3> <?php echo htmlspecialchars($data["GENDER"]);?>: * </h3>
        <div class="line">
            <label class="radio-label"> <?php echo htmlspecialchars($data["MALE"]);?> <input type="radio" id="genre" name="genre" value="homme" required> </label>
            <label class="radio-label"> <?php echo htmlspecialchars($data["FEMALE"]);?> <input type="radio" id="genre" name="genre" value="femme" required> </label>
            <label class="radio-label"> <?php echo htmlspecialchars($data["OTHER"]);?> <input type="radio" id="genre" name="genre" value="autre" required> </label>
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

        <label for="date_naissance"><h3><?php echo htmlspecialchars($data["BIRTHDAY"]);?>: * </h3></label>
        <input type="date" id="date_naissance" name="date_naissance" required>

        <label for="email"> <h3> <?php echo htmlspecialchars($data["EMAIL_LABEL"]);?>: * </h3> </label>
        <input type="email" id="email" name="email" required>

        <!-- TODO vérifier si l'adresse mail existe-->
        <?php
        ?>

        <label for="telephone"><h3> <?php echo htmlspecialchars($data["PHONE_NUMBER"]);?>: * </h3></label>
        <input type="tel" id="telephone" name="telephone" required>
        <small class="format-info" color="red" >Format: 0123456789</small>
        </fieldset>

        <div class="line">
            <div class="col">
                <label for="nationalite"><h3> <?php echo htmlspecialchars($data["NATIONALITY"]);?>: * </h3> </label>
                <select id="nationalite" name="nationalite" required>
                </select>

            </div>
            <div class="col">
                <label for="langues"> <h3><?php echo htmlspecialchars($data["LANGUAGES"]);?>: *</h3></label>
                <select id="langues" name="langues[]" multiple>
                </select>
                <!-- Champ de formulaire caché pour stocker les langues sélectionnées -->
                <input type="hidden" id="selectedLanguages" name="selectedLanguages" value="">
            </div>
            <!-- end of col -->
        </div><!-- end of line -->

        <h3> <?php echo htmlspecialchars($data["ADDRESS"]);?>: * </h3>
        <textarea id="name" name="name" rows="1" cols="1"></textarea>

        <label for="situation"> <h3> <?php echo htmlspecialchars($data["PERSONAL_SITUATION"]);?>: *</h3> </label>
        <select id="situation" name="situation" required>
            <option value="etudiant"><?php echo htmlspecialchars($data["STUDENT"]);?></option>
            <option value="employe"><?php echo htmlspecialchars($data["EMPLOYED"]);?></option>
            <option value="chomeur"><?php echo htmlspecialchars($data["UNEMPLOYED"]);?></option>
            <option value="retraite"><?php echo htmlspecialchars($data["RETIRED"]);?></option>
            <!-- Ajoutez d'autres options de situation personnelle ici -->
        </select>

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
        <h3><?php echo htmlspecialchars($data["SUPPORTING_DOCUMENTS"]);?>: *</h3>
        <form action="upload.php" method="post" enctype="multipart/form-data" required>
            <label for="pdfFile"><?php echo htmlspecialchars($data["SEND_LICENSE"]);?> : <br></label>
            <input type="file" id="pdfFile" name="pdfFile" accept=".pdf">
        </form>

        <h3><?php echo htmlspecialchars($data["EXPERIENCE"]);?>: </h3>
        <form action="upload.php" method="post" enctype="multipart/form-data" required>
            <label for="pdfFile"> <?php echo htmlspecialchars($data["SEND_RESUME"]);?> : <br></label>
            <input type="file" id="pdfFile" name="pdfFile" accept=".pdf">
        </form>

        <h3><?php echo htmlspecialchars($data["AVAILABILITY"]);?>: </h3>
        <div class="line">
            <label class="radio-label"> <?php echo htmlspecialchars($data["REGULAR_AVAILABILITY"]);?> <input type="radio" name="disponibilite" value="reguliere" required> </label>
            <label class="radio-label"> <?php echo htmlspecialchars($data["PUNCTUAL_AVAILABILITY"]);?> <input type="radio" name="disponibilite" value="ponctuelle" required> </label>
        </div>

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

        <div class="line">
            <div class="col">
                <label><input type="checkbox" id="lundi" name="jour" value="lundi"> <?php echo htmlspecialchars($data["MONDAY"]);?></label><br>
                <label><input type="checkbox" id="mardi" name="jour" value="mardi"> <?php echo htmlspecialchars($data["TUESDAY"]);?></label><br>
                <label><input type="checkbox" id="mercredi" name="jour" value="mercredi"> <?php echo htmlspecialchars($data["WEDNESDAY"]);?></label><br>
                <label><input type="checkbox" id="jeudi" name="jour" value="jeudi"> <?php echo htmlspecialchars($data["THURSDAY"]);?></label><br>
            </div>
            <div class="col">
                <label><input type="checkbox" id="vendredi" name="jour" value="vendredi"> <?php echo htmlspecialchars($data["FRIDAY"]);?></label><br>
                <label><input type="checkbox" id="samedi" name="jour" value="samedi"> <?php echo htmlspecialchars($data["SATURDAY"]);?></label><br>
                <label><input type="checkbox" id="dimanche" name="jour" value="dimanche"> <?php echo htmlspecialchars($data["SUNDAY"]);?></label><br>
            </div>
        </div>

        <h2> <?php echo htmlspecialchars($data["TERMS_LEGAL_NOTICES"]);?> </h2>
        <label>
            <?php echo htmlspecialchars($data["READ_ACCEPT"]);?> <a href="#" id="termsLink"> <?php echo htmlspecialchars($data["TERMS_LEGAL_NOTICES"]);?> *</a>
            <input type="checkbox" id="légales" name="conditions" value="légales" required>
        </label>

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

        <br>
        <label>
            <?php echo htmlspecialchars($data["WISH_MAIL_NEWS"]);?>
            <input type="checkbox" id="email_info" name="conditions" value="email_info">
        </label>
        <p><?php echo htmlspecialchars($data["DEMANDS_CHECKED"]);?>.</p>

        <button id="validationButton" class="btn confirm-button"><?php echo htmlspecialchars($data["CONFIRM"]);?></button>
    </div> <!-- end of form-content -->
</div> <!-- end of form-container -->

<script>
    // Fonction pour valider les champs obligatoires avant d'envoyer les données à l'API
    function validateFormAndSendData() {
        // Récupérer les champs obligatoires
        var requiredFields = document.querySelectorAll('[required]');


        for (var i = 0; i < requiredFields.length; i++) {
            var field = requiredFields[i];

            if (field.type === 'radio') {
                var radioGroup = document.getElementsByName(field.name);

                var isChecked = false;
                for (var j = 0; j < radioGroup.length; j++) {
                    if (radioGroup[j].checked) {
                        isChecked = true;
                        break;
                    }
                }

                if (!isChecked) {
                    radioGroup[0].scrollIntoView({ behavior: 'smooth', block: 'center' });

                    for (var k = 0; k < radioGroup.length; k++) {
                        radioGroup[k].style.outline = '2px solid red';
                    }

                    return false;
                }
            } else if (field.value === '') {
                field.scrollIntoView({ behavior: 'smooth', block: 'center' });

                field.style.border = '2px solid red';

                return false;
            }
        }

        sendDataToAPI();
    }

    // Événement de clic sur le bouton de validation
    document.getElementById('validationButton').addEventListener('click', function(event) {
        // Empêcher le comportement par défaut du bouton
        event.preventDefault();

        validateFormAndSendData();
    });

    function sendDataToAPI() {
        var genre = document.getElementById('genre').value;
        var nom = document.getElementById('nom').value;
        var prenom = document.getElementById('prenom').value;
        var date_naissance = document.getElementById('date_naissance').value;
        var email = document.getElementById('email').value;
        var telephone = document.getElementById('telephone').value;

        // Récupérer les cases cochées pour les permis
        var permisArray = [];
        var permisCheckboxes = document.querySelectorAll('input[name="permis"]:checked');
        permisCheckboxes.forEach(function(checkbox) {
            permisArray.push(checkbox.value);
        });

        var data = {
            genre: genre,
            nom: nom,
            prenom: prenom,
            date_naissance: date_naissance,
            email: email,
            telephone: telephone,
            type_permis: permisArray
        };

        // Convertir l'objet JSON en chaîne JSON
        var jsonData = JSON.stringify(data);

        var apiUrl = 'http://localhost:8082/index.php/volunteers/register';

        var options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: jsonData
        };

        // Envoyer les données à l'API via une requête HTTP POST
        fetch(apiUrl, options)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de l\'envoi des données à l\'API.');
                }
                return response.json();
            })
            .then(data => {
                // Traiter la réponse de l'API ici, si nécessaire
                console.log('Réponse de l\'API :', data);
                alert('Données envoyées avec succès à l\'API.');
            })
            .catch(error => {
                console.error('Erreur lors de l\'envoi des données à l\'API :', error);
                alert('Erreur lors de l\'envoi des données à l\'API.');
            });
    }
</script>
<script src="../scripts/nationalities.js"></script>
<script src="../scripts/languages.js"></script>
<script src="../scripts/terms_and_conditions.js"></script>
</body>

<?php
include_once('../includes/footer.php');
?>
</html>