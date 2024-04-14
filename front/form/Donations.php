<?php
ob_start(); // Commence la mise en tampon de sortie
include_once('../includes/head.php');
include_once('../includes/header.php');
include_once('../includes/lang.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/register.css">
    <title> <?php echo htmlspecialchars($data["MAKE_A_DONATION"]); ?> </title>
</head>

<div class="form-container">
    <div class="form-content">
        <div class="section">
            <h1> <?php echo htmlspecialchars($data["I_MAKE_A_DONATION"]); ?> </h1>
            <p> <?php echo htmlspecialchars($data["FORM_INTRO_DONATION"]); ?>
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
            </div><!-- end of col -->

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
            <div class="col">
                <h2> <?php echo htmlspecialchars($data["DONATION_INFORMATIONS"]);?> </h2>
                <label for="montant"> <h3> <?php echo htmlspecialchars($data["AMOUNT"]);?>: * </h3> </label>
                <input type="number" id="montant" name="montant" required>
            </div>

            <div class="col">
                <h3><?php echo htmlspecialchars($data["PAYMENT_MEANS"]);?>:*</h3>
                <div class="payment-list">
                    <button class="payment-button active" data-payment-method="paypal">
                        <h3>Paypal</h3>
                        <img src="../images/icones/Paypal.png" width="80" height="80">
                    </button>

                    <button class="payment-button" data-payment-method="card">
                        <h3><?php echo htmlspecialchars($data["BANK_CARD"]);?></h3>
                        <img src="../images/icones/credit-card.png" width="80" height="80">
                    </button>

                    <button class="payment-button" data-payment-method="bank-transfer">
                        <h3><?php echo htmlspecialchars($data["INSTANT_TRANSFER"]);?></h3>
                        <img src="../images/icones/bank-transfer.png" width="80" height="80">
                    </button>

                    <button class="payment-button" data-payment-method="check">
                        <h3><?php echo htmlspecialchars($data["CHECK"]);?></h3>
                        <img src="../images/icones/cheque.png" width="80" height="80">
                    </button>
                </div>
            </div>

            <div id="payment-details">
                <div id="paypal-details" class="payment-details">
                </div>

                <div id="card-details" class="payment-details">
                    <div class="line">
                        <div class="col">
                            <label for="nom"> <h3> <?php echo htmlspecialchars($data["CARD_NUMBER"]);?> : *</h3></label>
                            <input type="number" id="card_id" name="card_id" placeholder="1234 1234 1234 1234" required>
                        </div>
                        <div class="col">
                            <label for="prenom"> <h3><?php echo htmlspecialchars($data["EXPIRATION_DATE"]);?> : *</h3></label>
                            <input type="date" id="end_date" name="end_date" placeholder="MM/AA" required>
                        </div>
                        <div class="col">
                            <label for="control_number"> <h3><?php echo htmlspecialchars($data["CONTROL_NUMBER"]);?> : *</h3></label>
                            <input type="number" id="control_number" name="control_number" required>
                        </div>
                    </div>
                </div>

                <div id="bank-transfer-details" class="payment-details">
                    <label for="bank-select"><h3> <?php echo htmlspecialchars($data["BANK_SELECT"]);?>: * </h3> </label>
                    <select id="bank-select" name="bank" required>
                    </select>
                </div>

                <div id="check-details" class="payment-details">
                    <!-- Champs de saisie pour Chèque -->
                    <!-- Vous pouvez ajouter ici des champs de saisie spécifiques au Chèque -->
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
    </> <!-- end of form-content -->
</div> <!-- end of form-container -->
</body>

<script src="../scripts/bank_list.js"></script>
<script src="../scripts/nationalities.js"></script>
<script src="../scripts/terms_and_conditions.js"></script>
<script src="../scripts/payment_list.js"></script>

</html>

<?php
include_once('../includes/footer.php');
?>
