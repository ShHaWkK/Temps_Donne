<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Bénévole</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
}

.form-container {
    background-color: #fff;
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.form-title {
    text-align: center;
    color: #00334A;
    margin-bottom: 30px;
}

.input-group {
    margin-bottom: 20px;
}

.input-group h3 {
    color: #00334A;
    margin-bottom: 10px;
}

label {
    display: block;
    color: #333;
    margin-bottom: 5px;
}

input[type="text"],
input[type="date"],
input[type="email"],
input[type="tel"],
select,
input[type="checkbox"],
input[type="radio"],
button {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.radio-group label {
    margin-right: 20px;
}

button {
    background-color: #82CFD8;
    color: #fff;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
}

button:hover {
    background-color: #00334A;
}

.required {
    color: red;
}

select[multiple] {
    height: auto;
}

    </style>
</head>
<body>
<div class="form-container">
    <form id="volunteerRegistrationForm" action="submit_volunteer_form.php" method="post">
        <legend>
        <h2 class="form-title">JE DEVIENS BÉNÉVOLE</h2>
        </legend>
        <p class="form-description">Le bénévolat, comme la solidarité, peuvent prendre diverses formes! Ce formulaire aidera notre équipe de bénévoles à vous proposer des missions faites pour vous.</p>            
            
            <!-- Informations Personnelles -->
            <div class="form-group">
                <label>Genre: <span class="mandatory">*</span></label>
                <div class="radio-group">
                    <label><input type="radio" name="genre" value="homme" required> Homme</label>
                    <label><input type="radio" name="genre" value="femme" required> Femme</label>
                    <label><input type="radio" name="genre" value="autre" required> Autre</label>
                </div>
            </div>


            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="date_naissance">Date de naissance:</label>
            <input type="date" id="date_naissance" name="date_naissance" required>

            <label for="email">Adresse mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="telephone">Numéro de téléphone:</label>
            <input type="tel" id="telephone" name="telephone" required>

            <label for="nationalite">Nationalité:</label>
            <input type="text" id="nationalite" name="nationalite" required>

            <div class="input-group">
                <label for="langues">Langues: <span class="required">*</span></label>
                <select id="langues" name="langues[]" multiple required>
                <option value="francais">Français</option>
                <option value="anglais">Anglais</option>
                <option value="espagnol">Espagnol</option>
                <option value="allemand">Allemand</option>
                <option value="italien">Italien</option>
                <option value="arabe">Arabe</option>
                <option value="chinois">Chinois</option>
                <option value="japonais">Japonais</option>
                <option value="russe">Russe</option>
                <option value="portugais">Portugais</option>
                <option value="hindi">Hindi</option>
                <option value="bengali">Bengali</option>
                <option value="punjabi">Punjabi</option>
                <option value="javanais">Javanais</option>
                <option value="telegu">Telegu</option>
                <option value="marathi">Marathi</option>
                <option value="tamil">Tamil</option>
                <option value="turc">Turc</option>
                <option value="vietnamien">Vietnamien</option>
                <option value="coréen">Coréen</option>
                <option value="thaï">Thaï</option>
                <option value="polonais">Polonais</option>
                <option value="ukrainien">Ukrainien</option>
                <option value="roumain">Roumain</option>
                <option value="grec">Grec</option>
                <option value="tchèque">Tchèque</option>
                <option value="hongrois">Hongrois</option>
                <option value="bulgare">Bulgare</option>
                <option value="danois">Danois</option>
                <option value="finnois">Finnois</option>
                <option value="norvégien">Norvégien</option>
                <option value="suédois">Suédois</option>
                <option value="néerlandais">Néerlandais</option>
                <option value="portugais">Portugais</option>
                <option value="géorgien">Géorgien</option>
                <option value="arménien">Arménien</option>
                <option value="albanais">Albanais</option>
                <option value="serbe">Serbe</option>
                <option value="croate">Croate</option>
                <option value="bosniaque">Bosniaque</option>
                <option value="macédonien">Macédonien</option>
                <option value="monténégrin">Monténégrin</option>
                <option value="slovène">Slovène</option>
                <option value="slovaque">Slovaque</option>
                <option value="lituanien">Lituanien</option>
                <option value="letton">Letton</option>
                <option value="estonien">Estonien</option>
                <option value="biélorusse">Biélorusse</option>
                <option value="arménien">Arménien</option>
                <option value="azerbaïdjanais">Azerbaïdjanais</option>
                <option value="kazakh">Kazakh</option>
                <option value="ouzbek">Ouzbek</option>
                <option value="tadjik">Tadjik</option>
                <option value="turkmène">Turkmène</option>
                <option value="kirghiz">Kirghiz</option>
                <option value="mongol">Mongol</option>
                <option value="tibétain">Tibétain</option>
                <option value="nepali">Népalais</option>
                <option value="bhoutanais">Bhoutanais</option>
                <option value="sri_lankais">Sri Lankais</option>
                <option value="maldivien">Maldivien</option>
                <option value="indonésien">Indonésien</option>
                <option value="malais">Malais</option>
                <option value="philippin">Philippin</option>
                <option value="singapourien">Singapourien</option>
                <option value="thaïlandais">Thaïlandais</option>
                <option value="birman">Birman</option>
                <option value="laotien">Laotien</option>
                <option value="cambodgien">Cambodgien</option>
                <option value="vietnamien">Vietnamien</option>
            </select>

            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" required>

            <label for="situation_personnelle">Situation personnelle:</label>
            <select id="situation_personnelle" name="situation_personnelle" required>
                <option value="etudiant">Étudiant</option>
                <option value="employe">Employé</option>
                <option value="chomeur">Chômeur</option>
                <option value="retraite">Retraité</option>
                <!-- Ajoutez d'autres options de situation personnelle ici -->

            </select>

            <label for="situation_familiale">Situation familiale:</label>
            <select id="situation_familiale" name="situation_familiale" required>
                <option value="celibataire">Célibataire</option>
                <option value="marie">Marié(e)</option>
                <option value="divorce">Divorcé(e)</option>
                <option value="veuf">Veuf/Veuve</option>
                <option value="en_couple">En couple</option>
                <option value="separe">Séparé(e)</option>
            </select>

            <label for="enfants">Nombre d'enfants:</label>
            <input type="number" id="enfants" name="enfants" required>

            <label for="emploi">Emploi:</label>
            <input type="text" id="emploi" name="emploi" required>
    

            <!-- Ajoutez les champs pour les disponibilités et les services ici -->
                <fieldset>
                    <legend>Disponibilités:</legend>
                        <div class="availability-options">
                            <label><input type="radio" name="availability" value="regular"> Disponibilité régulière</label>
                            <label><input type="radio" name="availability" value="punctual"> Disponibilité ponctuelle</label>
                        </div>
                        <label><input type="checkbox" name="disponibilite[]" value="lundi"> Lundi</label>
                        <label><input type="checkbox" name="disponibilite[]" value="mardi"> Mardi</label>
                        <label><input type="checkbox" name="disponibilite[]" value="mercredi"> Mercredi</label>
                        <label><input type="checkbox" name="disponibilite[]" value="jeudi"> Jeudi</label>
                        <label><input type="checkbox" name="disponibilite[]" value="vendredi"> Vendredi</label>
                        <label><input type="checkbox" name="disponibilite[]" value="samedi"> Samedi</label>
                        <label><input type="checkbox" name="disponibilite[]" value="dimanche"> Dimanche</label>
                </fieldset>

                <section class="availability-section">
                <h3>Disponibilités et Domaine d'Intervention:</h3>
                <!-- Mobility -->
                <div class="input-group">
                    <label>Mobilité: <span class="required">*</span></label>
                    <input type="checkbox" id="permisB" name="mobility" value="permisB"><label for="permisB">Permis B</label>
                    <input type="checkbox" id="permisPoidsLourd" name="mobility" value="permisPoidsLourd"><label for="permisPoidsLourd">Permis Poids Lourd</label>
                    <input type="checkbox" id="caces" name="mobility" value="caces"><label for="caces">CACES</label>
                </div>
                <!-- Services -->
                <div class="input-group">
                    <label>Services:</label>
                    <select id="services" name="services">
                        <!-- Pour une association humanitaire -->
                        <option value="aideAlimentaire">Aide Alimentaire</option>
                        <option value="aideVestimentaire">Aide Vestimentaire</option>
                        <option value="aideLogement">Aide au Logement</option>
                        <option value="aideScolaire">Aide Scolaire</option>
                        <option value="aideAdministrative">Aide Administrative</option>
                        <option value="aideJuridique">Aide Juridique</option>
                        <option value="aideMedicale">Aide Médicale</option>
                        <option value="aideEmploi">Aide à l'Emploi</option>
                        <option value="aideHandicap">Aide Handicap</option>
                        <option value="aidePersonnesAgees">Aide aux Personnes Âgées</option>
                        <option value="aideEnfants">Aide aux Enfants</option>
                        <option value="aideAnimaux">Aide aux Animaux</option>
                        <option value="aideEnvironnement">Aide à l'Environnement</option>
                        <option value="aideCulture">Aide à la Culture</option>
                        <option value="aideSport">Aide au Sport</option>
                        <option value="aidechauffeur">Aide Chauffeur</option>
                        <option value="aiderecolte">Aide à la Récolte</option>
                        <option value="aideLoisirs">Aide aux Loisirs</option>
                        <option value="aideVoyages">Aide aux Voyages</option>
                        <option value="aideUrgence">Aide d'Urgence</option>
                        <
                    </select>
                </div>

            <div class="form-group terms">
                <label><input type="checkbox" name="terms" required> J'accepte les termes et mentions légales</label>
                </div>
                <div class="form-group newsletter">
                    <label><input type="checkbox" name="newsletter"> Je souhaite recevoir des informations de la part de "Au temps donné"</label>
                </div>
            </div>
            <button type="submit" name="submit">Valider</button>
    </form>

    <!-- Insérez vos scripts JavaScript ici pour la validation côté client -->
    <script>
        document.getElementById('formInscription').addEventListener('submit', function(e) {
            var errors = [];
            var nom = document.getElementById('nom').value;
            var prenom = document.getElementById('prenom').value;
            var email = document.getElementById('email').value;
            var telephone = document.getElementById('telephone').value;
            var nationalite = document.getElementById('nationalite').value;
            var adresse = document.getElementById('adresse').value;

            if (nom.length < 3) {
                errors.push('Le nom doit contenir au moins 3 caractères.');
            }

            if (prenom.length < 3) {
                errors.push('Le prénom doit contenir au moins 3 caractères.');
            }

            if (email.indexOf('@') === -1) {
                errors.push('Adresse e-mail invalide.');
            }

            if (telephone.length < 10) {
                errors.push('Numéro de téléphone invalide.');
            }

            if (nationalite.length < 3) {
                errors.push('Nationalité invalide.');
            }

            if (adresse.length < 5) {
                errors.push('Adresse invalide.');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    </script>
</body>
</html>
