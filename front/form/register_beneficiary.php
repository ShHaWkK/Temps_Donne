<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="../css/register.css">
</head>

<?php
include_once('../includes/head.php');
include_once('../includes/header.php');

echo "<title>Services - Au temps donné</title>";
?>

<body>

<div class="form-container">
    <div class="form-content">
        <h1> Je deviens Bénéficiaire </h1>
        <p>Chez "Au temps donné", nous sommes convaincus de la diversité des expressions de solidarité.
        En remplissant ce formulaire, vous nous permettez de cerner vos besoins spécifiques,
        ce qui nous aidera à vous proposer des missions adaptées à vos capacités et aspirations.
        </p>
        <h2> Informations personnelles </h2>
        <h3> Genre: * </h3>
        <div class="line"> 
            <label class="radio-label"> Homme <input type="radio" name="genre" value="homme" required> </label>
            <label class="radio-label"> Femme <input type="radio" name="genre" value="femme" required> </label>
            <label class="radio-label"> Autre <input type="radio" name="genre" value="autre" required> </label>
        </div>
        
        <div class="line">
            <div class="col">
            <label for="nom"> <h3>Nom: *</h3></label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="col">
                <label for="prenom"> <h3>Prénom: *</h3></label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
        </div> 

        <label for="date_naissance"><h3> Date de naissance: * </h3></label>
        <input type="date" id="date_naissance" name="date_naissance" required>  

        <label for="email"> <h3> Adresse mail: * </h3> </label>
        <input type="email" id="email" name="email" required>
        
        <!-- TODO vérifier si l'adresse mail existe-->
        <?php
        ?> 

        <label for="telephone"><h3> Numéro de téléphone: * </h3></label>
        <input type="tel" id="telephone" name="telephone" required>
        <small class="format-info" color="red" >Format: 0123456789</small>
        </fieldset>

        <div class="line">
            <div class="col">
                <label for="nationalite"><h3> Nationalité: * </h3> </label>
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
            <label for="langues"> <h3>Langues: *</h3><span class="langues" multiple required></span></label>
                <select id="langues" name="langues[]" >
                    <?php
                        $langues = array(
                            "Français", "Anglais", "Espagnol", "Allemand", "Italien", "Arabe", "Chinois", "Japonais", "Russe", 
                            "Portugais", "Hindi", "Bengali", "Punjabi", "Javanais", "Telegu", "Marathi", "Tamil", "Turc", 
                            "Vietnamien", "Coréen", "Thaï", "Polonais", "Ukrainien", "Roumain", "Grec", "Tchèque", "Hongrois", 
                            "Bulgare", "Danois", "Finnois", "Norvégien", "Suédois", "Néerlandais", "Géorgien", "Arménien", 
                            "Albanais", "Serbe", "Croate", "Bosniaque", "Macédonien", "Monténégrin", "Slovène", "Slovaque", 
                            "Lituanien", "Letton", "Estonien", "Biélorusse", "Arménien", "Azerbaïdjanais", "Kazakh", "Ouzbek", 
                            "Tadjik", "Turkmène", "Kirghiz", "Mongol", "Tibétain", "Népalais", "Bhoutanais", "Sri Lankais", 
                            "Maldivien", "Indonésien", "Malais", "Philippin", "Singapourien", "Thaïlandais", "Birman", "Laotien", 
                            "Cambodgien", "Vietnamien"
                        );
                        foreach ($langues as $langue) {
                            echo "<option value=\"$langue\">$langue</option>";
                        }
                    ?>
                </select>
            </div>        <!-- end of col -->
        </div><!-- end of line -->

        <label for="adresse"><h3> Adresse: * </h3></label>
        <input type="text" id="adresse" name="adresse" required>

        <label for="situation_personnelle"> <h3> Situation personnelle: *</h3> </label>
            <select id="situation_personnelle" name="situation_personnelle" required>
                <option value="etudiant">Étudiant</option>
                <option value="employe">Employé</option>
                <option value="chomeur">Chômeur</option>
                <option value="retraite">Retraité</option>
                <!-- Ajoutez d'autres options de situation personnelle ici -->  
            </select>

        <h2> Besoins et attentes </h2>

        <label for="services"> <h3> Service(s) demandé(s): *</h3><span class="services" multiple required></span></label>
        <select id="services" class="multiple" name="services[]" multiple >
            <option value="alphabetisation">Cours d'alphabetisation pour adulte </option>
            <option value="alphabetisation">Visite de personnes agées </option>
        </select>

        <h2>Termes et mentions légales </h2>
        <label>
        J’ai lu et j'accepte les <a href=""> termes et mentions légales: *</a>
        <input type="checkbox" id="légales" name="conditions" value="légales">  
        </label>
        <br>
        <label>
        Je souhaite recevoir des informations de la part de “Au temps donné" par email
        <input type="checkbox" id="email_info" name="conditions" value="email_info">  
        </label>
        <p>Les demandes seront examinées attentivement par notre équipe, qui se réserve le droit d'accepter ou de refuser
         une demande en fonction des besoins de l'association et des disponibilités des bénévoles.</p>

         <button class="confirm-button">Valider</button>
    </div> <!-- end of form-content -->
</div> <!-- end of form-container -->
</body>

<?php
include_once('../includes/footer.php');
?>
</html>

<script>
    var xhr = new XMLHttpRequest();

    xhr.open('GET', '../header/header.php', true);

    xhr.onload = function() {

        if (xhr.status === 200) {
            document.getElementById('header').innerHTML = xhr.responseText;
            // Ajouter le contenu de header.php et inclure darkmode.js après
            includeDarkModeScript();
        }
    };

    xhr.send();

    function includeDarkModeScript() {
        var script = document.createElement('script');
        script.src = "../scripts/darkmode.js";
        document.body.appendChild(script);
    }
</script>