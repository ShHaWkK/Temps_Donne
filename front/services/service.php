<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./css/services.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <title>Services</title>
</head>

<body>

<div id="header"></div>

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

</html>

<script>
    var xhr = new XMLHttpRequest();

    xhr.open('GET', '../header/header.php', true);

    xhr.onload = function() {

        if (xhr.status === 200) {
            document.getElementById('header').innerHTML = xhr.responseText;

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