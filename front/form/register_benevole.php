<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="../css/register.css">
</head>

<?php
include_once('../includes/head.php');
include_once('../includes/header.php');

echo "<title>Inscription bénévole - Au temps donné</title>";
?>

<body>
<div class="form-container">
    <form id="volunteerRegistrationForm" action="register_benevole.php" method="post" enctype="multipart/form-data">        <h2 class="form-title">JE DEVIENS BÉNÉVOLE</h2>
        </legend>
        <p class="form-description">Le bénévolat, comme la solidarité, peuvent prendre diverses formes! Ce formulaire aidera notre équipe de bénévoles à vous proposer des missions faites pour vous.</p>

        <fieldset>
            <legend>Informations Personnelles</legend>
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
            <small class="format-info" color="red" >Format: 0123456789</small>
        </fieldset>

        <label for="nationalite">Nationalité:</label>
        <input type="text" id="nationalite" name="nationalite" required>

        <div class="input-group">
            <label for="langues">Langues: <span class="required">*</span></label>
            <select id="langues" name="langues[]" multiple required>
                <option value="francais">Français</option>
                <option value="anglais">Anglais</option>
                <option value="espagnol">Espagnol</option>
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


            <fieldset>
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
            </fieldset>

            <label for="emploi">Emploi:</label>
            <input type="text" id="emploi" name="emploi" required>


            <!-- Disponibilités -->
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

            <!-- Mobility -->
            <section class="availability-section">
                <h3>Disponibilités et Domaine d'Intervention:</h3>
                <label for="type_permis">Type de Permis :</label>
                <select id="type_permis" name="type_permis">
                    <option value="aucun">Aucun</option>
                    <option value="permisB">Permis B</option>
                    <option value="permisPoidsLourd">Permis Poids Lourd</option>
                    <option value="caces">CACES</option>
                </select>
            </section>

            <!-- Services -->

            <div class="input-group">
                <label>Services:</label>
                <select id="services" name="services">
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
                </select>
            </div>


            <!-- Photo de profil -->

            <section class="photo-section">
                <label for="photo">Photo de profil:</label>
                <input type="file" id="photo_profil" name="photo_profil" required>
            </section>
            <!-- Terms and newsletter -->

            <div class="form-group terms">
                <label><input type="checkbox" name="terms" required> J'accepte les termes et mentions légales</label>
            </div>
            <div class="form-group newsletter">
                <label><input type="checkbox" name="newsletter"> Je souhaite recevoir des informations de la part de "Au temps donné"</label>
            </div>
        </div>

        <button type="submit" name="submit" value="Bénévole">Valider</button>
    </form>

    <!-- Insérez vos scripts JavaScript ici pour la validation côté client -->
    <script>
        document.getElementById('formInscription').addEventListener('submit', function(e) {
            var errors = [];
            var nom = document.getElementById('nom').value;
            var prenom = document.getElementById('prenom').value;
            var genre = document.getElementById('genre').value;
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

        // * => obligatoire à remplir
        document.getElementById('volunteerRegistrationForm').addEventListener('submit', function(e) {
            var inputs = document.querySelectorAll('input, select, textarea');
            var errors = [];

            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].hasAttribute('required') && inputs[i].value === '') {
                    errors.push('Le champ ' + inputs[i].name + ' est obligatoire.');
                }
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    </script>
</body>
</html>
