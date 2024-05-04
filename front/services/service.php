<html>
<head>
    <link rel="stylesheet" href="../css/services.css">
    <title>Services</title>
</head>

<?php
include_once('../includes/head.php');
include_once('../includes/header.php');

echo "<title>Services - Au temps donné</title>";
?>

<body>

<div class="main-container">
    <h1>Nom du service</h1>
    <p>
        Ac ne quis a nobis hoc ita dici forte miretur, quod alia quaedam in hoc facultas sit ingeni,
        neque haec dicendi ratio aut disciplina, ne nos quidem huic uni studio penitus umquam dediti fuimus.
        Etenim omnes artes, quae ad humanitatem pertinent, habent quoddam commune vinculum, et quasi cognatione quadam
        inter se continentur.
    </p>
    <img src="../images/mains-solidarite.jpg" class="service-picture">
    <h2> Nos actions vous intéressent ? </h2>
    <button class="btn confirm-button">Devenez bénévole chez "Au temps donné"</button>
    <button class="btn confirm-button">Faites un don</button>
</div>
</body>

<?php
include_once('../includes/footer.php');
?>

</html>

<script>
    // Appel du script darkmode.js directement
    includeDarkModeScript();

    function includeDarkModeScript() {
        var script = document.createElement('script');
        script.src = "../scripts/darkmode.js";
        document.body.appendChild(script);
    }
</script>
