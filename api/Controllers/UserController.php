<?php
require_once './Services/UserService.php';
require_once './Models/UserModel.php';
require_once './exceptions.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/BDD.php';
require_once './Services/AvailabilityService.php';

class UserController {
    public $userService;
    public $availabilityService;

    public function __construct() {
        $db = connectDB();
        $userRepository = new UserRepository($db);
        $this->userService = new UserService($userRepository);
        $availabilityRepository = new AvailabilityRepository($db);
        $this->availabilityService = new AvailabilityService($availabilityRepository);
    }

    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        switch ($uri[3]){
                            case'Granted':
                            case'Pending':
                            case'Denied':
                                $this->getAllUsersByRoleAndStatus($uri[2],$uri[3]);
                                break;
                            case 'All':
                                $this->getAllUsersByRole($uri[2]);
                                break;
                            case 'Mail':
                                $this->getUserByEmail($uri[4]);
                                break;
                            default:
                                $this->getUser($uri[3]);
                                break;
                        }
                    }else{
                        $this->getAllUsers();
                    }
                case 'POST':
                    if ($uri[3] === 'register') {
                        $this->createUser();
                    }
                    break;
                case 'PUT':
                    if (isset($uri[3])) {
                        $this->updateUser($uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deleteUser($uri[3]);
                    }
                    break;
                default:
                    ResponseHelper::sendNotFound();
                    break;
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }
    public function getUser($id) {
        // Vérification du rôle
        /*
        if (!$this->checkRole('admin_OLD')) {
            throw new Exception("Accès non autorisé.");
        }
        */
        // Récupération de l'utilisateur
        $user = $this->userService->getUserById($id);
        if (!$user) {
            ResponseHelper::sendNotFound("User not found.");
        } else {
            ResponseHelper::sendResponse($user);
        }
    }

    public function createUser() {
        $data = json_decode($_POST['json_data'], true);
        try {
            $user = new UserModel($data);
            $user->validate($data);
            $this->userService->registerUser($user);


            $insertedUser = $this->userService->findByEmail($data['Email']);
            $availability = new AvailabilityModel($data,$insertedUser->id_utilisateur);
            $this->availabilityService->createAvailability($availability);

            if ($_FILES['cv_file'] && isset($_FILES['permis_file']) !== null)
                $filesSaved=$this->saveUploadedFiles($data);

            http_response_code(200);
            $response = [
                'status' => 'success',
                'message' => 'User added successfully.',
                'inserted_id' => $insertedUser->id_utilisateur,
            ];

            if (!$filesSaved) {
                $response['remark'] = "L'utilisateur a été enregistré, mais les fichiers justificatifs n'ont pas été envoyés.";
            }

            ResponseHelper::sendResponse($response);

        } catch (Exception $e) {
            /*
            http_response_code($e->getCode());
            echo json_encode(array("message" => $e->getMessage()));*/
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function saveUploadedFiles($data)
    {
        if (empty($_FILES)) {
            throw new Exception("Aucun fichier n'a été téléchargé.");
        }

        $permis_file = $_FILES['permis_file'];
        $cv_file = $_FILES['cv_file'];
        $target_dir_permis = "./uploads/" . $data["Email"] . "/Permis/";
        $target_dir_CV = "./uploads/" . $data["Email"] . "/CV/";

        if (!file_exists($target_dir_permis)) {
            mkdir($target_dir_permis, 0777, true);
        }

        if (!file_exists($target_dir_CV)) {
            mkdir($target_dir_CV, 0777, true);
        }

        $permis_file_path = $target_dir_permis . "Permis_" . $data['Nom'] . "_" . $data['Prenom'] . "_" . date("Y-m-d_H-i-s") . ".pdf";
        $cv_file_path = $target_dir_CV . "CV_" . $data['Nom'] . "_" . $data['Prenom'] . "_" . date("Y-m-d_H-i-s") . ".pdf";

        $permis_file_moved = move_uploaded_file($permis_file['tmp_name'], $permis_file_path);
        $cv_file_moved = move_uploaded_file($cv_file['tmp_name'], $cv_file_path);

        if (!$permis_file_moved) {
            throw new Exception("Une erreur s'est produite lors de l'enregistrement du permis.");
        }

        if (!$cv_file_moved) {
            throw new Exception("Une erreur s'est produite lors de l'enregistrement du CV.");
        }

        return [
            'permis_file' => "Le justificatif du permis a bien été enregistré.",
            'cv_file' => "Le CV a bien été enregistré."
        ];
    }

    //-------------------- Delete User -------------------//
    public function deleteUser($id) {
        try {
            $result = $this->userService->deleteUser($id);
            if ($result) {
                ResponseHelper::sendResponse(['success' => 'Utilisateur supprimé avec succès.']);
            } else {
                ResponseHelper::sendNotFound('Utilisateur non trouvé.');
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    //-------------------- Update User -------------------//
    private function updateUser($id)
    {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            ResponseHelper::sendResponse(["error" => "Invalid JSON: " . json_last_error_msg()], 400);
            return;
        }

        try {
            $fieldsToUpdate = array_keys($data);
            $user = $this->userService->getuserById($id);
            // Mettre à jour les champs spécifiques
            foreach ($fieldsToUpdate as $field) {
                $user->$field = $data[$field];
            }

            $this->userService->updateUser($user, $fieldsToUpdate);
            ResponseHelper::sendResponse(["Utilisateur mis à jour avec succès."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    //-------------------- Access Control -------------------//
    public function accessVolunteerSpace($userId) {
        if (!$this->userService->checkVolunteerStatus($userId)) {
            throw new Exception("Accès non autorisé. Bénévole non validé.");
        }
        // Logique pour accéder à l'espace privé du bénévole
        ResponseHelper::sendResponse(["message" => "Accès autorisé. Bienvenue dans votre espace bénévole."]);

    }

    //-------------------- Récupérer les utilisateurs -------------------//

    public function getAllUsers() {
        try {
            $users = $this->userService->getAllUsers();
            ResponseHelper::sendResponse($users);
        }catch (Exception $e){
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    private function getAllUsersByRole($role)
    {
        try {
            switch ($role){
                case 'volunteers':
                    $users = $this->userService->getAllUsersByRole('Benevole');
                    break;
                case 'beneficiaries':
                    $users =$this->userService->getAllUsersByRole('Beneficiaire');
                    break;
            }
            ResponseHelper::sendResponse($users);
        }catch (Exception $e){
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    public function getAllUsersByRoleAndStatus($role,$statut)
    {
        try {
            switch ($role){
                case 'volunteers':
                    $users = $this->userService->getAllUsersByRoleAndStatus('Benevole',$statut);
                    break;
                case 'beneficiaries':
                    $users =$this->userService->getAllUsersByRoleAndStatus('Beneficiaire',$statut);
                    break;
                case 'admins':
                    $users =$this->userService->getAllUsersByRoleAndStatus('Administrateur',$statut);
                    break;
            }
            ResponseHelper::sendResponse($users);
        }catch (Exception $e){
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    /*
private function checkRole($requiredRole) {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $user = $this->userService->getUserById($_SESSION['user_id']);
    return $user->role_effectif === $requiredRole;
}*/

    /*
public function updateUser($id) {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        ResponseHelper::sendResponse(["error" => "Invalid JSON: " . json_last_error_msg()], 400);
        return;
    }

    try {
        $user = new UserModel($data);
        $user->id_utilisateur = $id;
        $this->userService->updateUserProfile($user);
        ResponseHelper::sendResponse(["success" => "Utilisateur mis à jour avec succès."]);
    } catch (Exception $e) {
        ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
    }
}*/
    private function getUserByEmail($email)
    {
        $user = $this->userService->findByEmail($email);
        if (!$user) {
            ResponseHelper::sendNotFound("User not found.");
        } else {
            ResponseHelper::sendResponse($user);
        }
    }

}