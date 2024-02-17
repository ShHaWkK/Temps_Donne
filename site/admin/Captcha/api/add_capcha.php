<?php
session_start();
include_once('Connection.php');
echo "Admin ID: " . (isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : "Non défini");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifiez si l'administrateur est connecté et obtenez l'ID
if (!isset($_SESSION['admin_id'])) {
    echo "Erreur : Vous devez être connecté en tant qu'administrateur pour ajouter un captcha.";
    exit; // Arrêtez le script si l'administrateur n'est pas connecté
}
$id_administrateur = $_SESSION['admin_id'];
if (isset($_POST['submit'])) {
    $img = $_FILES['image']['name'];
    $img_tmp = $_FILES['image']['tmp_name'];
    $img_ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

    $valid_extensions = array('jpg', 'jpeg', 'png');
    if (in_array($img_ext, $valid_extensions)) {
        $unique_folder_name = uniqid('capcha_', true);
        $upload_dir = "image/$unique_folder_name";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $tiles_per_row = 3;
        $tiles_per_col = 3;

        $img_resource = imagecreatefromstring(file_get_contents($img_tmp));
        $img_width = imagesx($img_resource);
        $img_height = imagesy($img_resource);

        $tile_width = intval(floor($img_width / $tiles_per_row));
        $tile_height = intval(floor($img_height / $tiles_per_col));

        for ($row = 0; $row < $tiles_per_col; $row++) {
            for ($col = 0; $col < $tiles_per_row; $col++) {
                $tile_img = imagecreatetruecolor($tile_width, $tile_height);

                imagecopyresampled($tile_img, $img_resource, 0, 0,
                    $col * $tile_width, $row * $tile_height,
                    $tile_width, $tile_height, $tile_width, $tile_height);

                $tile_name = ($row * $tiles_per_row + $col + 1) . '.jpg';
                $tile_path = "$upload_dir/$tile_name";

                imagejpeg($tile_img, $tile_path, 100);
                imagedestroy($tile_img);
            }
        }

        $full_img_name = '10.jpg';
        $full_img_path = "$upload_dir/$full_img_name";
        move_uploaded_file($img_tmp, $full_img_path);

        imagedestroy($img_resource);
        

        $image_path = $full_img_path;
        $answer = "Réponse"; 
        $id_administrateur = $id_administrateur;

        try {
            $query = "INSERT INTO captchas (Image_Path, Answer, ID_Administrateur) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$image_path, $answer, $id_administrateur]);
        } catch (PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
            exit;
        }

        header('Location: list_capcha.php?status=success');
        exit;
    } else {
        echo "L'image doit être au format jpg, jpeg ou png.";
    }
}
?>
