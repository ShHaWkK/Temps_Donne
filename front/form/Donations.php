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

</div>

<div class="form-container">
    <div class="form-content">
        <h1> Je fais un don </h1>
        <p>Changez des vies avec "Au Temps Donné"! Chaque don compte pour soutenir ceux qui en ont besoin.
            Contribuez à cette mission de solidarité et d'espoir.
            Votre contribution est notre force.
            Agissons maintenant, pour un monde plus juste et solidaire!
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
                </select>

            </div>
            <div class="col">
                <label for="langues"> <h3>Langues: *</h3><span class="required" multiple required></span></label>
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

        <h3> Adresse: * </h3>
        <textarea id="name" name="name" rows="1" cols="1"></textarea>

        <label for="situation_personnelle"> <h3> Situation personnelle: *</h3> </label>
        <select id="situation_personnelle" name="situation_personnelle" required>
            <option value="etudiant">Étudiant</option>
            <option value="employe">Employé</option>
            <option value="chomeur">Chômeur</option>
            <option value="retraite">Retraité</option>
            <!-- Ajoutez d'autres options de situation personnelle ici -->
        </select>

        <h2> Informations de donation </h2>
        <label for="montant"> <h3> Montant: * </h3> </label>
        <input type="number" id="montant" name="montant" required>

        <h3>Moyen de réglement:*</h3>
        <div class="payment-list">
            <button class="payment-button">
                <h3>Paypal</h3>
                <img src="../images/icones/Paypal.png" width="80" height="80">
            </button>

            <button class="payment-button">
                <h3>Carte Bancaire</h3>
                <img src="../images/icones/credit-card.png" width="80" height="80">
            </button>

            <button class="payment-button">
                <h3>Virement instantanné</h3>
                <img src="../images/icones/bank-transfer.png" width="80" height="80">
            </button>

            <button class="payment-button">
                <h3>chéque</h3>
                <img src="../images/icones/cheque.png" width="80" height="80">
            </button>
        </div>

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

        <button class="btn confirm-button">Valider</button>
    </div> <!-- end of form-content -->
</div> <!-- end of form-container -->
</body>

<?php
include_once('../includes/footer.php');
?>
</html>