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
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        button {
            background-color: #00334A;
            color: #fff;
            border: none;
            padding: 10px 15px;
            margin-right: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #002333;
        }
    </style>
</style>
</head>
<body>
    <button onclick="window.location.href = 'add_capcha.php';">Ajouter un captcha</button>
    <button onclick="window.location.href = 'api/list_suppr.php';">Supprimer tous les captchas</button>
</body>
</html>