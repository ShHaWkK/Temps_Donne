<?php
require_once './Repository/SkillRepository.php'; // Assurez-vous que le chemin est correct

class SkillService
{private $skillRepository;

    public function __construct(SkillRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
    }

    public function createSkill($skill)
    {
        try {
            return $this->skillRepository->createSkill($skill);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de la compétence : " . $e->getMessage());
        }
    }

    public function getSkillById($id)
    {
        try {
            return $this->skillRepository->getSkillById($id);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de la compétence : " . $e->getMessage());
        }
    }

    public function getAllSkills()
    {
        try {
            return $this->skillRepository->getAllSkills();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de toutes les compétences : " . $e->getMessage());
        }
    }

    public function getUserSkills($id_utilisateur)
    {
        try {
            // Récupérer les ID de compétences de l'utilisateur
            $userSkills = $this->skillRepository->getUserSkills($id_utilisateur);
            // Extraire les ID de compétences dans un tableau
            $ids_competences = array_column($userSkills, 'ID_Competence');

            if (empty($ids_competences)) {
                return [];
            }

            // Récupérer les détails des compétences associées à l'utilisateur
            $userSkillsDetails = $this->skillRepository->getUserSkillsDetails($ids_competences);

            // Combiner les détails des compétences avec les ID de compétences
            /*
            foreach ($userSkills as &$userSkill) {
                foreach ($userSkillsDetails as $skillDetail) {
                    if ($skillDetail['ID_Competence'] == $userSkill['ID_Competence']) {
                        $userSkill['Details'] = $skillDetail;
                        break;
                    }
                }
            }*/

            return $userSkillsDetails;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des compétences de l'utilisateur : " . $e->getMessage());
        }
    }

    public function assignSkill($userID, $skillID)
    {
        try {
            return $this->skillRepository->assignSkill($userID,$skillID);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de la compétence : " . $e->getMessage());
        }
    }

}
?>