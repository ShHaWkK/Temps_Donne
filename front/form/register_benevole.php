<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once('../BDD/Connection.php');
require_once('check_attempts.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = ($_POST['nom']);
    $prenom = ($_POST['prenom']);
    $email = ($_POST['email']);
    $telephone = ($_POST['telephone']);
    $adresse = ($_POST['adresse']);
    $dateNaissance = ($_POST['date_naissance']);
    $nationalite = ($_POST['nationalite']);
    $langues = implode(', ', ('', $_POST['langues']));
    $situation = ($_POST['situation_personnelle']);
    $type_permis = isset($_POST['type_permis']) ? ($_POST['type_permis']) : 'aucun';
    $date_inscription = date('Y-m-d');

   

    if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] == 0) {
        // Traitez le téléchargement de la photo
        $photo_profil = $_FILES['photo_profil']['name'];
        $photo_path = "uploads/" . md5($email) . "/";
        if (!file_exists($photo_path)) {
            mkdir($photo_path, 0777, true);
        }
        $photo_path .= basename($photo_profil);
        move_uploaded_file($_FILES['photo_profil']['tmp_name'], $photo_path);
    } else {
        $photo_profil = '';
    }
       
// Vérifiez si l'utilisateur a téléchargé une photo de profil
if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] == 0) {
    // Vérifiez si le fichier n'est pas trop gros
    if ($_FILES['photo_profil']['size'] <= 1000000) {
        // Extension autorisées et vérification du type de fichier
        $allowed_extensions = array('jpg', 'jpeg', 'png');
        $file_extension = pathinfo($_FILES['photo_profil']['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            // Créez un dossier unique pour chaque utilisateur pour stocker leur photo
            $user_folder = '../uploads/' . $email . '/';

            if (!is_dir($user_folder)) {
                mkdir($user_folder, 0777, true);
            }

            // Nom du fichier et chemin
            $photo_path = $user_folder . uniqid() . '.' . $file_extension;
            
            // Déplacez le fichier téléchargé
            move_uploaded_file($_FILES['photo_profil']['tmp_name'], $photo_path);
        }
    }
}

$sql = "INSERT INTO utilisateurs (Nom, Prenom, Email, Telephone, Adresse, Date_de_naissance, Nationalite, Langues, Situation, Type_Permis, Date_d_inscription, Photo_profil) 
VALUES (:nom, :prenom, :email, :telephone, :adresse, :dateNaissance, :nationalite, :langues, :situation, :type_permis, :date_inscription, :photo_profil)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':dateNaissance', $dateNaissance);
    $stmt->bindParam(':nationalite', $nationalite);
    $stmt->bindParam(':langues', $langues);
    $stmt->bindParam(':situation', $situation);
    $stmt->bindParam(':type_permis', $type_permis);
    $stmt->bindParam(':date_inscription', $date_inscription);
    $stmt->bindParam(':photo_profil', $photo_path);
    try {
        $stmt->execute();
        echo "Inscription réussie.";
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion des données : " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription Bénévole</title>
    <style>
        /* Main styling */
        body,
        input,
        select,
        button,
        textarea {
            font-family: 'Open Sans', sans-serif;
        }

        .form-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            color: #00334A;
            margin-bottom: 1rem;
        }

        .form-description {
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Form inputs */
        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Radio buttons and checkboxes */
        .radio-group,
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            margin-bottom: 1rem;
        }

        .radio-group label,
        .checkbox-group label {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: #f7f7f7;
            border: 1px solid #ddd;
            padding: 0.5rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .format-info {
            color: red;
        }

        input[type="radio"]:checked+label,
        input[type="checkbox"]:checked+label {
            background-color: #00334A;
            color: white;
            border-color: #00334A;
        }

        /* Styling for checkmarks */
        .checkmark {
            display: inline-block;
            width: 22px;
            height: 22px;
            background: white;
            border-radius: 50%;
            position: relative;
        }

        .checkbox-group .checkmark {
            border-radius: 4px;
        }

        /* Submit button */
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #00506b;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #00334A;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .radio-group,
            .checkbox-group {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }
        }
    </style>
</head>

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
            <?php

            $sqlEmailCheck = "SELECT COUNT(*) FROM utilisateurs WHERE Email = :email";
            $stmtEmailCheck = $conn->prepare($sqlEmailCheck);
            $stmtEmailCheck->bindParam(':email', $email);
            $stmtEmailCheck->execute();
            
            if ($stmtEmailCheck->fetchColumn() > 0) {
                echo "Un utilisateur avec cet email existe déjà.";

            } else {
                echo "Cet email est disponible.";
            }
             
            ?>

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
