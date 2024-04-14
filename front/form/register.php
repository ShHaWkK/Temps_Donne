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
                    <option value="AF">Afghanistan</option>
                    <option value="ZA">Afrique du Sud</option>
                    <option value="AL">Albanie</option>
                    <option value="DZ">Algérie</option>
                    <option value="DE">Allemagne</option>
                    <option value="AD">Andorre</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguilla</option>
                    <option value="AQ">Antarctique</option>
                    <option value="AG">Antigua-et-Barbuda</option>
                    <option value="SA">Arabie Saoudite</option>
                    <option value="AR">Argentine</option>
                    <option value="AM">Arménie</option>
                    <option value="AW">Aruba</option>
                    <option value="AU">Australie</option>
                    <option value="AT">Autriche</option>
                    <option value="AZ">Azerbaïdjan</option>
                    <option value="BS">Bahamas</option>
                    <option value="BH">Bahreïn</option>
                    <option value="BD">Bangladesh</option>
                    <option value="BB">Barbade</option>
                    <option value="BY">Biélorussie</option>
                    <option value="BE">Belgique</option>
                    <option value="BZ">Belize</option>
                    <option value="BJ">Bénin</option>
                    <option value="BM">Bermudes</option>
                    <option value="BT">Bhoutan</option>
                    <option value="BO">Bolivie</option>
                    <option value="BA">Bosnie-Herzégovine</option>
                    <option value="BW">Botswana</option>
                    <option value="BR">Brésil</option>
                    <option value="BN">Brunéi Darussalam</option>
                    <option value="BG">Bulgarie</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BI">Burundi</option>
                    <option value="KH">Cambodge</option>
                    <option value="CM">Cameroun</option>
                    <option value="CA">Canada</option>
                    <option value="CV">Cap-Vert</option>
                    <option value="CL">Chili</option>
                    <option value="CN">Chine</option>
                    <option value="CY">Chypre</option>
                    <option value="CO">Colombie</option>
                    <option value="KM">Comores</option>
                    <option value="CG">Congo</option>
                    <option value="KP">Corée du Nord</option>
                    <option value="KR">Corée du Sud</option>
                    <option value="CR">Costa Rica</option>
                    <option value="CI">Côte d'Ivoire</option>
                    <option value="HR">Croatie</option>
                    <option value="CU">Cuba</option>
                    <option value="DK">Danemark</option>
                    <option value="DJ">Djibouti</option>
                    <option value="DM">Dominique</option>
                    <option value="EG">Égypte</option>
                    <option value="SV">El Salvador</option>
                    <option value="AE">Émirats arabes unis</option>
                    <option value="EC">Équateur</option>
                    <option value="ER">Érythrée</option>
                    <option value="ES">Espagne</option>
                    <option value="EE">Estonie</option>
                    <option value="US">États-Unis</option>
                    <option value="ET">Éthiopie</option>
                    <option value="FK">Îles Falkland</option>
                    <option value="FO">Îles Féroé</option>
                    <option value="FJ">Fidji</option>
                    <option value="FI">Finlande</option>
                    <option value="FR" selected>France</option>
                    <option value="GA">Gabon</option>
                    <option value="GM">Gambie</option>
                    <option value="GE">Géorgie</option>
                    <option value="GS">Géorgie du Sud et îles Sandwich du Sud</option>
                    <option value="GH">Ghana</option>
                    <option value="GI">Gibraltar</option>
                    <option value="GR">Grèce</option>
                    <option value="GD">Grenade</option>
                    <option value="GL">Groenland</option>
                    <option value="GP">Guadeloupe</option>
                    <option value="GU">Guam</option>
                    <option value="GT">Guatemala</option>
                    <option value="GG">Guernesey</option>
                    <option value="GN">Guinée</option>
                    <option value="GQ">Guinée équatoriale</option>
                    <option value="GW">Guinée-Bissau</option>
                    <option value="GY">Guyana</option>
                    <option value="GF">Guyane française</option>
                    <option value="HT">Haïti</option>
                    <option value="HN">Honduras</option>
                    <option value="HU">Hongrie</option>
                    <option value="BV">Île Bouvet</option>
                    <option value="CX">Île Christmas</option>
                    <option value="AC">Île de l'Ascension</option>
                    <option value="IM">Île de Man</option>
                    <option value="NF">Île Norfolk</option>
                    <option value="AX">Îles Åland</option>
                    <option value="KY">Îles Caïmans</option>
                    <option value="CC">Îles Cocos</option>
                    <option value="CK">Îles Cook</option>
                    <option value="UM">Îles mineures éloignées des États-Unis</option>
                    <option value="SB">Îles Salomon</option>
                    <option value="TC">Îles Turques-et-Caïques</option>
                    <option value="VG">Îles Vierges britanniques</option>
                    <option value="VI">Îles Vierges des États-Unis</option>
                    <option value="IN">Inde</option>
                    <option value="ID">Indonésie</option>
                    <option value="IR">Iran</option>
                    <option value="IQ">Iraq</option>
                    <option value="IE">Irlande</option>
                    <option value="IS">Islande</option>
                    <option value="IL">Israël</option>
                    <option value="IT">Italie</option>
                    <option value="JM">Jamaïque</option>
                    <option value="JP">Japon</option>
                    <option value="JE">Jersey</option>
                    <option value="JO">Jordanie</option>
                    <option value="KZ">Kazakhstan</option>
                    <option value="KE">Kenya</option>
                    <option value="KG">Kirghizistan</option>
                    <option value="KI">Kiribati</option>
                    <option value="KW">Koweït</option>
                    <option value="LA">Laos</option>
                    <option value="LS">Lesotho</option>
                    <option value="LV">Lettonie</option>
                    <option value="LB">Liban</option>
                    <option value="LR">Libéria</option>
                    <option value="LY">Libye</option>
                    <option value="LI">Liechtenstein</option>
                    <option value="LT">Lituanie</option>
                    <option value="LU">Luxembourg</option>
                    <option value="MK">Macédoine</option>
                    <option value="MG">Madagascar</option>
                    <option value="MY">Malaisie</option>
                    <option value="MW">Malawi</option>
                    <option value="MV">Maldives</option>
                    <option value="ML">Mali</option>
                    <option value="MT">Malte</option>
                    <option value="MP">Îles Mariannes du Nord</option>
                    <option value="MA">Maroc</option>
                    <option value="MH">Îles Marshall</option>
                    <option value="MQ">Martinique</option>
                    <option value="MU">Maurice</option>
                    <option value="MR">Mauritanie</option>
                    <option value="YT">Mayotte</option>
                    <option value="MX">Mexique</option>
                    <option value="FM">Micronésie</option>
                    <option value="MD">Moldavie</option>
                    <option value="MC">Monaco</option>
                    <option value="MN">Mongolie</option>
                    <option value="MS">Montserrat</option>
                    <option value="MZ">Mozambique</option>
                    <option value="MM">Myanmar</option>
                    <option value="NA">Namibie</option>
                    <option value="NR">Nauru</option>
                    <option value="NP">Népal</option>
                    <option value="NI">Nicaragua</option>
                    <option value="NE">Niger</option>
                    <option value="NG">Nigéria</option>
                    <option value="NU">Niue</option>
                    <option value="NO">Norvège</option>
                    <option value="NC">Nouvelle-Calédonie</option>
                    <option value="NZ">Nouvelle-Zélande</option>
                    <option value="OM">Oman</option>
                    <option value="UG">Ouganda</option>
                    <option value="UZ">Ouzbékistan</option>
                    <option value="PK">Pakistan</option>
                    <option value="PW">Palaos</option>
                    <option value="PS">Palestine</option>
                    <option value="PA">Panama</option>
                    <option value="PG">Papouasie-Nouvelle-Guinée</option>
                    <option value="PY">Paraguay</option>
                    <option value="NL">Pays-Bas</option>
                    <option value="PE">Pérou</option>
                    <option value="PH">Philippines</option>
                    <option value="PN">Îles Pitcairn</option>
                    <option value="PL">Pologne</option>
                    <option value="PF">Polynésie française</option>
                    <option value="PR">Porto Rico</option>
                    <option value="PT">Portugal</option>
                    <option value="QA">Qatar</option>
                    <option value="HK">R.A.S. chinoise de Hong Kong</option>
                    <option value="MO">R.A.S. chinoise de Macao</option>
                    <option value="CF">République centrafricaine</option>
                    <option value="CD">République démocratique du Congo</option>
                    <option value="DO">République dominicaine</option>
                    <option value="CZ">République tchèque</option>
                    <option value="RE">Réunion</option>
                    <option value="RO">Roumanie</option>
                    <option value="GB">Royaume-Uni</option>
                    <option value="RU">Russie</option>
                    <option value="RW">Rwanda</option>
                    <option value="EH">Sahara occidental</option>
                    <option value="BL">Saint-Barthélémy</option>
                    <option value="SH">Sainte-Hélène</option>
                    <option value="KN">Saint-Kitts-et-Nevis</option>
                    <option value="LC">Sainte-Lucie</option>
                    <option value="SM">Saint-Marin</option>
                    <option value="MF">Saint-Martin</option>
                    <option value="PM">Saint-Pierre-et-Miquelon</option>
                    <option value="VC">Saint-Vincent-et-les Grenadines</option>
                    <option value="WS">Samoa</option>
                    <option value="AS">Samoa américaines</option>
                    <option value="ST">Sao Tomé-et-Principe</option>
                    <option value="SN">Sénégal</option>
                    <option value="RS">Serbie</option>
                    <option value="SC">Seychelles</option>
                    <option value="SL">Sierra Leone</option>
                    <option value="SG">Singapour</option>
                    <option value="SK">Slovaquie</option>
                    <option value="SI">Slovénie</option>
                    <option value="SO">Somalie</option>
                    <option value="SD">Soudan</option>
                    <option value="SS">Soudan du Sud</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="SE">Suède</option>
                    <option value="CH">Suisse</option>
                    <option value="SR">Suriname</option>
                    <option value="SJ">Svalbard et Île Jan Mayen</option>
                    <option value="SZ">Swaziland</option>
                    <option value="SY">Syrie</option>
                    <option value="TJ">Tadjikistan</option>
                    <option value="TW">Taïwan</option>
                    <option value="TZ">Tanzanie</option>
                    <option value="TD">Tchad</option>
                    <option value="TF">Terres australes françaises</option>
                    <option value="IO">Territoire britannique de l'océan Indien</option>
                    <option value="PS">Territoire palestinien</option>
                    <option value="TH">Thaïlande</option>
                    <option value="TL">Timor oriental</option>
                    <option value="TG">Togo</option>
                    <option value="TK">Tokelau</option>
                    <option value="TO">Tonga</option>
                    <option value="TT">Trinité-et-Tobago</option>
                    <option value="TN">Tunisie</option>
                    <option value="TM">Turkménistan</option>
                    <option value="TR">Turquie</option>
                    <option value="TV">Tuvalu</option>
                    <option value="UA">Ukraine</option>
                    <option value="UY">Uruguay</option>
                    <option value="VU">Vanuatu</option>
                    <option value="VE">Venezuela</option>
                    <option value="VN">Viet Nam</option>
                    <option value="WF">Wallis-et-Futuna</option>
                    <option value="YE">Yémen</option>
                    <option value="ZM">Zambie</option>
                    <option value="ZW">Zimbabwe</option>
                </select>

            </div>
            <div class="col">
                <label for="langues"> <h3><?php echo htmlspecialchars($data["LANGUAGES"]);?>: *</h3></label>
                <select id="langues" name="langues[]" multiple >
                    <option value="francais">Francais</option>
                    <option value="anglais">Anglais</option>
                    <option value="espagnol">Espagnol</option>
                </select>
            </div>        <!-- end of col -->
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

    // Récupérer les éléments du DOM
    var termsLink = document.getElementById('termsLink');
    var modal = document.getElementById('termsModal');
    var closeBtn = document.getElementsByClassName('close')[0];

    // Lorsque l'utilisateur clique sur le lien des termes
    termsLink.onclick = function() {
        modal.style.display = 'block'; // Afficher la fenêtre modale
    }

    // Lorsque l'utilisateur clique sur le bouton "fermer"
    closeBtn.onclick = function() {
        modal.style.display = 'none'; // Masquer la fenêtre modale
    }

    // Lorsque l'utilisateur clique en dehors de la fenêtre modale, elle se ferme
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none'; // Masquer la fenêtre modale
        }
    }

    // Lorsque l'utilisateur clique sur le lien des termes
    termsLink.onclick = function(event) {
        event.preventDefault(); // Empêcher le comportement par défaut du lien
        modal.style.display = 'block'; // Afficher la fenêtre modale
    }
</script>

</body>

<?php
include_once('../includes/footer.php');
?>
</html>