<?php
    include('api/list_suppr.php')
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste</title>
    <style>
        #capcha {
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;
    color: rgb(80, 197, 227);
}

#title {
    height: 150px;
    width: 400px;
}

#board {
    position: relative; /* nouvelle ligne */
    width: 300px;
    height: 300px;
    background-color: rgb(96, 240, 233);
    border: 10px solid rgb(21, 162, 190);

    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
}

#board img {
width: calc(100% / 3);
height: calc(100% / 3);
border: 1px solid #0c67ae;
margin: 0px;
padding: 0px;
box-sizing: border-box;
}

#board img:hover {
    cursor: pointer;
}
</style>
</head>
<body>
    <button onclick="window.location.href = 'add_capcha.php';">Ajouter un captcha</button>
</body>
</html>