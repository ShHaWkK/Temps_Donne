<?php
session_start();
include_once('api/Connection.php');
include_once('api/add_capcha.php'); 

if (isset($_SESSION['admin_id'])) {
    $id_administrateur = $_SESSION['admin_id'];
} else {
    echo "Erreur : Vous devez être connecté en tant qu'administrateur.";
    exit;
}

    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload et découpage d'image</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body, html {
            font-family: 'Bebas Neue', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .upload-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container {
            position: relative; 
            margin-bottom: 40px; 
            background-color: #ffffff;
            padding: 2rem;
        }
        h2 {
            color: #00334A;
            text-align: center;
            margin-bottom: 1rem;
        }
        .input-field {
            margin-bottom: 1rem;
            position: relative;
        }
        .input-field label {
            display: block;
            color: #82CFD8;
            margin-bottom: 0.5rem;
        }
        .input-field input[type="file"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 0.5rem;
        }
        button {
            display: block;
            width: 100%;
            background-color: #82CFD8;
            color: #ffffff;
            padding: 0.75rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #00334A;
        }
        .format-info {
            text-align: center;
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.5rem;
        }

    </style>
</head>
<body>
<div class="form-container">
    <h2>Upload et découpage d'image</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="input-field">
            <label for="image"><i class="fa fa-image"></i> Choisir une image :</label>
            <input type="file" name="image" id="image">
            <div class="format-info">L'image doit être au format jpg, jpeg ou png.</div>
        </div>
        <!-- Place for error message if needed -->
        <?php if (isset($error_message) && !empty($error_message)): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <button type="submit" name="submit">Upload</button>
    </form>
</div>
</body>
</html>


