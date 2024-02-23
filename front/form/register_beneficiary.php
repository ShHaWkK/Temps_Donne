<?php
session_start();
error_reporting(E_ALL); 
ini_set('display_errors', 1);
require_once('Connection.php'); 
require_once('check_attempts.php');


function validatePhoneNumber($number) {

    return preg_match('/^[0-9]{10}$/', $number); 

}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telephone = htmlspecialchars($_POST['telephone']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $dateNaissance = htmlspecialchars($_POST['date_naissance']);
    $nationalite = htmlspecialchars($_POST['nationalite']);
    $langues = implode(', ', array_map('htmlspecialchars', $_POST['langues']));
    $emploi = htmlspecialchars($_POST['emploi'] ?? '');
    $societe = htmlspecialchars($_POST['societe'] ?? '');
    $photo_profil = htmlspecialchars($_POST['photo_profil'] ?? '');
    $role = 'Beneficiaire';
    $date_inscription = date('Y-m-d H:i:s');

    $sql = "INSERT INTO Utilisateurs (Nom, Prenom, Email, Telephone, Adresse, Date_de_naissance, Langues, Nationalite, Role, Emploi, Societe, Date_d_inscription, Photo_profil) VALUES (:nom, :prenom, :email, :telephone, :adresse, :dateNaissance, :langues, :nationalite, :role, :emploi, :societe, NOW(), :photo_profil";

     // Validation des données
     if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !validatePhoneNumber($telephone)) {
        die('Données invalides.');
    }

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':dateNaissance', $dateNaissance);
        $stmt->bindParam(':langues', $langues);
        $stmt->bindParam(':nationalite', $nationalite);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':emploi', $emploi);
        $stmt->bindParam(':societe', $societe);
        $stmt->bindParam(':date_inscription', $date_inscription);
        $stmt->bindParam(':photo_profil', $photo_path);

        $stmt->execute();
        echo "Inscription réussie.";
    } catch (PDOException $e) {
        echo "Erreur lors de l'inscription : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Devenir Bénéficiaire</title>
    <meta name="description" content="Formulaire d'inscription pour devenir bénéficiaire">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        /* Reset margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and general styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
            padding: 20px;
            color: #333;
        }

        .form-container {
            background: #fff;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Form title */
        h1 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        /* Form description */
        p {
            margin-bottom: 30px;
            line-height: 1.6;
            color: #666;
        }

        /* Form fieldset */
        fieldset {
            border: none;
            margin-bottom: 20px;
        }

        /* Form legend */
        legend {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #0056b3;
            font-weight: bold;
        }

        /* Form label */
        label {
            display: block;
            margin-bottom: 5px;
        }

        /* Form input fields */
        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="tel"],
        select,
        button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Multiple select */
        select[multiple] {
            height: auto;
        }

        /* Radio buttons and checkboxes */
        .radio-group,
        .checkbox-group {
            margin-bottom: 15px;
        }

        .radio-group label,
        .checkbox-group label {
            margin-right: 10px;
        }

        /* Icon style */
        .icon {
            margin-right: 5px;
            color: #0056b3;
        }

        /* Terms and newsletter */
        .terms,
        .newsletter {
            margin-bottom: 20px;
        }

        /* Submit button */
        button {
            background-color: #0056b3;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #003d82;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
            padding-top: 50px;
        }
        .form-container {
            background: white;
            padding: 25px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .header-image {
            width: 100%;
            height: 300px;
            background: url('images/etopia.jpg') no-repeat center center;
            background-size: cover;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .form-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #0056b3;
        }
        .form-description {
            margin-bottom: 20px;
            font-size: 14px;
        }
        .icon {
            color: #0056b3;
        }
        button[type="submit"] {
            background-color: #0056b3;
            color: #fff;
            padding: 10px 30px;
            border-radius: 5px;
            font-size: 18px;
        }
        button[type="submit"]:hover {
            background-color: #004494;
        }
        .terms, .newsletter {
            margin-bottom: 10px;
        }
        .form-footer {
            margin-top: 20px;
        }
        .is-invalid {
            border-color: #dc3545;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="beneficiaryRegistrationForm" method="post" enctype="multipart/form-data"<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="form-container">
                    <div class="header-image"></div>
                    <div class="form-body">
                        <h2 class="form-title">JE DEVIENS BÉNÉFICIAIRE</h2>
                        <p class="form-description">En remplissant ce formulaire, vous nous permettez de cerner vos besoins spécifiques, ce qui nous aidera à vous proposer des missions adaptées à vos capacités et aspirations.</p>
            <fieldset>
                <legend>Informations Personnelles:</legend>
                    <label for="genre"><i class="fa fa-user icon"></i>Genre:<color style="color: red;">*</color></label>
                    <input type="radio" id="homme" name="genre" value="homme" required> Homme
                    <input type="radio" id="femme" name="genre" value="femme" required> Femme
                    <input type="radio" id="autre" name="genre" value="autre" required> Autre
                
                
                <label for="nom"><i class="fa fa-user icon"></i>Nom: <color style="color: red;">*</color></label>
                <input type="text" id="nom" name="nom"  placeholder="Votre nom" required>
                
                <label for="prenom">Prénom: <color style="color: red;">*</color></label>
                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
                
                <label for="date_naissance">Date de naissance: <color style="color: red;">*</color></label>
                <input type="date" id="date_naissance" name="date_naissance"  placeholder="Votre date de naissance" required>
                
                <label for="email">Adresse mail: <color style="color: red;">*</color></label>
                <input type="email" id="email" name="email"  placeholder="Votre adresse mail" required>
                
                <label for="telephone">Numéro de téléphone: <color style="color: red;">*</color></label>
                <input type="tel" id="telephone" name="telephone" placeholder="Votre numéro de téléphone" required>
                
                <label for="nationalite">Nationalité:<color style="color: red;">*</color></label>
                <input type="text" id="nationalite" name="nationalite" placeholder="Votre nationalité" required>
            </fieldset>
                
                <label for="langues">Langues: <color style="color: red;">*</color></label>
                <select id="langues" name="langues[]" multiple required>
                    <!-- Options de langues -->
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

                
                <label for="adresse">Adresse: <color style="color: red;">*</color></label>
                <input type="text" id="adresse" name="adresse" placeholder="Votre adresse" required>
                
                <label for="situation_personnelle">Situation personnelle: <color style="color: red;">*</color></label>
                <select id="situation_personnelle" name="situation_personnelle" placeholder="Votre situation personnelle" required>
                    <!-- Options de situation personnelle -->
                    <option value="celibataire">Célibataire</option>
                    <option value="marie">Marié(e)</option>
                    <option value="divorce">Divorcé(e)</option>
                    <option value="veuf">Veuf(ve)</option>
                    <option value="en_couple">En couple</option>
                    <option value="separe">Séparé(e)</option>
                </select>
            </fieldset>

            <fieldset>
                <legend>Informations Professionnelles:</legend>
                
                <label for="emploi">Emploi actuel:</label>
                <input type="text" id="emploi" name="emploi" placeholder="Votre emploi actuel">

                <label for="societe">Société / Organisation:</label>
                <input type="text" id="societe" name="societe" placeholder="Nom de votre société ou organisation">
            </fieldset>

            
            <fieldset>
                <legend>Besoins et Attentes:</legend>
                <label for="services">Service(s) demandé(s): <color style="color: red;">*</color></label>
                <select id="services" name="services[]" multiple required>
                    <!-- Options de services -->
                    <option value="aide_menagere">Aide ménagère</option>
                    <option value="aide_personnelle">Aide personnelle</option>
                    <option value="aide_administrative">Aide administrative</option>
                    <option value="aide_cuisine">Aide à la cuisine</option>
                    <option value="aide_transport">Aide au transport</option>
                    <option value="aide_loisirs">Aide aux loisirs</option>
                    <option value="aide_informatique">Aide informatique</option>
                    <option value="aide_jardinage">Aide au jardinage</option>
                    <option value="aide_bricolage">Aide au bricolage</option>

                    
                </select>
            </fieldset>

            <fieldset>
                <legend>Photo de Profil:</legend>
                <label for="photo_profil">Photo de profil:<color style="color: red;">*</color></label>
                <input type="file" id="photo_profil" name="photo_profil" required>
            </fieldset>

            <fieldset>
                <legend>Conditions d'Utilisation:</legend>
                
                <label>
                    <input type="checkbox" name="terms" required> J'accepte les termes et mentions légales<color style="color: red;">*</color>
                </label>
                
                <label>
                    <input type="checkbox" name="newsletter"> Je souhaite recevoir des informations de la part de "Au temps donné"<color style="color: red;">*</color>
                </label>

                <label>
                    <input type="checkbox" name="acceptation"> Les demandes seront examinées attentivement par notre équipe, qui se réserve le droit d'accepter ou de refuser une demande en fonction des besoins de l'association et des disponibilités des bénévoles.<color style="color: red;">*</color>
                </label>
            </fieldset>
            
            <button type="submit" name="submit"><i class="fas fa-paper-plane"></i> Valider</button>
        </form>
    </div>
    <script>
        const form = document.getElementById('beneficiaryRegistrationForm');
            // Récupération des valeurs des champs

            form.addEventListener('submit', function(event) {
                const genre = form.genre.value;
                const nom = form.nom.value;
                const prenom = form.prenom.value;
                const date_naissance = form.date_naissance.value;
                const email = form.email.value;
                const telephone = form.telephone.value;
                const nationalite = form.nationalite.value;
                const langues = form.langues.value;
                const adresse = form.adresse.value;
                const situation_personnelle = form.situation_personnelle.value;
                const services = form.services.value;
                const terms = form.terms.checked;
                const newsletter = form.newsletter.checked;

                console.log('Genre:', genre);
                console.log('Nom:', nom);
                console.log('Prénom:', prenom);
                console.log('Date de naissance:', date_naissance);
                console.log('Email:', email);
                console.log('Téléphone:', telephone);
                console.log('Nationalité:', nationalite);
                console.log('Langues:', langues);
                console.log('Adresse:', adresse);
                console.log('Situation personnelle:', situation_personnelle);
                console.log('Services:', services);
                console.log('Terms:', terms);
                console.log('Newsletter:', newsletter);
            });

        document.getElementById('beneficiaryRegistrationForm').addEventListener('submit', function(event) {
        let isValid = true;
            const requiredFields = this.querySelectorAll('[required]');

            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'red';

                } else {
                    field.style.borderColor = 'initial';
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert('Veuillez remplir tous les champs requis.');
            }
        });
    </script>
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
