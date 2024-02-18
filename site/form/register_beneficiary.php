<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Devenir Bénéficiaire</title>
    <style>
        /* Vos styles CSS iraient ici */
    </style>
</head>
<body>
    <div class="form-container">
        <form id="beneficiaryRegistrationForm" action="register_beneficiary.php" method="post">
            <h1>JE DEVIENS BÉNÉFICIAIRE</h1>
            <p>En remplissant ce formulaire, vous nous permettez de cerner vos besoins spécifiques, ce qui nous aidera à vous proposer des missions adaptées à vos capacités et aspirations.</p>
            
            <fieldset>
                <legend>Informations Personnelles:</legend>
                <label for="genre">Genre: *</label>
                <input type="radio" id="homme" name="genre" value="homme" required> Homme
                <input type="radio" id="femme" name="genre" value="femme" required> Femme
                
                <label for="nom">Nom: *</label>
                <input type="text" id="nom" name="nom" required>
                
                <label for="prenom">Prénom: *</label>
                <input type="text" id="prenom" name="prenom" required>
                
                <label for="date_naissance">Date de naissance: *</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
                
                <label for="email">Adresse mail: *</label>
                <input type="email" id="email" name="email" required>
                
                <label for="telephone">Numéro de téléphone: *</label>
                <input type="tel" id="telephone" name="telephone" required>
                
                <label for="nationalite">Nationalité: *</label>
                <input type="text" id="nationalite" name="nationalite" required>
                
                <label for="langues">Langues: *</label>
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

                
                <label for="adresse">Adresse: *</label>
                <input type="text" id="adresse" name="adresse" required>
                
                <label for="situation_personnelle">Situation personnelle: *</label>
                <select id="situation_personnelle" name="situation_personnelle" required>
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
                <legend>Besoins et Attentes:</legend>
                <label for="services">Service(s) demandé(s): *</label>
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

            
            <label>
                <input type="checkbox" name="terms" required> J'accepte les termes et mentions légales
            </label>
            
            <label>
                <input type="checkbox" name="newsletter"> Je souhaite recevoir des informations de la part de "Au temps donné"
            </label>
            
            <button type="submit" name="submit">Valider</button>
        </form>
    </div>

    <!-- Scripts JavaScript si nécessaire -->
    <script>
    </script>
</body>
</html>
