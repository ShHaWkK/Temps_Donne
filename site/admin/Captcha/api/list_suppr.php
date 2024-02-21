<?php
include_once('Connection.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
function rrmdir($src) {
    $dir = opendir($src);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            $full = $src . '/' . $file;
            if (is_dir($full)) {
                rrmdir($full);
            } else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
}

$dir = "image";
$capcha_folders = array_filter(glob("$dir/capcha*"), 'is_dir');

foreach ($capcha_folders as $capcha_folder) {
    echo "<div class='capcha-container'>";
    $image_path = "$capcha_folder/10.jpg";
    $capcha_name = basename($capcha_folder);

    if (file_exists($image_path) && !is_dir($image_path)) {
        echo "<h3>$capcha_name</h3>";
        echo "<img src='$image_path' alt='capcha' class='capcha-img'>";
        echo "<form method='POST'>
                <input type='hidden' name='capcha_name' value='$capcha_name'>
                <input type='submit' name='delete_capcha' value='Supprimer' class='delete-btn'>
              </form>";
    } else {
        echo "<p>Erreur : l'image $image_path n'a pas pu être récupérée.</p>";
    }
    echo "</div>";
}

if (isset($_POST['delete_capcha'])) {
    $capcha_name = $_POST['capcha_name'];
    $capcha_folder_path = "image/$capcha_name";
    if (is_dir($capcha_folder_path)) {
        rrmdir($capcha_folder_path);
    }
    // La redirection doit être à l'extérieur du if
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>
<style>
:root {
    --primary-color: #82CFD8; /* Primary color for the header and sidebar */
    --secondary-color: #00334A; /* Secondary color for buttons and table headers */
    --text-color: #000000; /* Main text color */
    --background-color: #FFFFFF; /* Main background color */
    --error-color: #ff4d4d; /* Color for error messages */
}

body {
    font-family: Arial, sans-serif;
    background-color: var(--background-color);
    margin: 0;
    padding: 0;
}

.capcha-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    border: 1px solid var(--secondary-color);
    border-radius: 10px;
    margin: 20px;
    padding: 20px;
    background-color: var(--primary-color);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
}

.capcha-img {
    margin-bottom: 15px;
    width: 300px;
    border-radius: 10px;
}

h3 {
    color: var(--text-color);
    margin-bottom: 10px;
}

.delete-btn {
    background-color: var(--error-color);
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.delete-btn:hover {
    background-color: #ff3333;
}


</style>
</body>
</html>
