<?php
require_once './Services/SkillService.php'; // Assurez-vous que le chemin est correct

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class SkillController
{
    private $skillService;

    public function __construct() {
        $db = connectDB();
        $skillRepository = new SkillRepository($db);
        $this->skillService = new SkillService($skillRepository);
    }
    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        switch ($uri[3]){
                            case 'All':
                                return $this->getAllSkills();
                            case 'User':
                                if (isset($uri[4])) {
                                    return $this->getUserSkills($uri[4]);
                                } else {
                                    throw new Exception("ID utilisateur non spécifié.");
                                }
                            default:
                                throw new Exception("URI invalide.");
                        }
                    } else {
                        throw new Exception("URI invalide.");
                    }
                    break;
                case 'POST':
                    if (isset($uri[3])){
                        switch ($uri[3]){
                            case 'create':
                                $this->createSkill();
                                break;
                            case 'assign':
                                $this->assignSkill($uri[4],$uri[5]);
                                break;
                        }

                    } else {
                        throw new Exception("URI invalide.");
                    }
                    break;
                default:
                    throw new Exception("Méthode HTTP non autorisée.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function createSkill()
    {
        try {
            $json = file_get_contents("php://input");
            $data = json_decode($json, true);

            $insertedId = $this->skillService->createSkill($data);

            ResponseHelper::sendResponse(["Compétence ajoutée avec succès." => $insertedId]);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de la compétence : " . $e->getMessage());
        }
    }

    public function getSkillById($id)
    {
        try {
            $skill = $this->skillService->getSkillById($id);

            return json_encode($skill);
        } catch (Exception $e) {
            // Gérer les erreurs
            throw new Exception("Erreur lors de la récupération de la compétence : " . $e->getMessage());
        }
    }

    public function getAllSkills()
    {
        try {
            $result = $this->skillService->getAllSkills();
            if ($result) {
                ResponseHelper::sendResponse(['success' => $result]);
            } else {
                ResponseHelper::sendNotFound('Aucune compétence enregistrée.');
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function getUserSkills($id_utilisateur)
    {
        try {
            $userSkills = $this->skillService->getUserSkills($id_utilisateur);

            ResponseHelper::sendResponse(['success' => $userSkills]);
            return json_encode($userSkills);
        } catch (Exception $e) {
            // Gérer les erreurs
            throw new Exception("Erreur lors de la récupération des compétences de l'utilisateur : " . $e->getMessage());
        }
    }

    private function assignSkill($userID, $skillID)
    {

        try {
             $this->skillService->assignSkill($userID,$skillID);

            ResponseHelper::sendResponse(["Compétence correctement asisgnée à l'utilisateur."]);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'assignation de la compétence : " . $e->getMessage());
        }
    }
}