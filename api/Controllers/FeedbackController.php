<?php

require_once './Services/FeedbackService.php';
require_once './Helpers/ResponseHelper.php';

class FeedbackController {
    private $feedbackService;

    public function __construct() {
        $this->feedbackService = new FeedbackService(new FeedbackRepository());
    }

    public function processRequest($method, $uri) {
        switch ($method) {
            case 'GET':
                if (isset($uri[3])) {
                    $this->getFeedback($uri[3]);
                } else {
                    $this->getAllFeedbacks();
                }
                break;
            case 'POST':
                $this->createFeedback();
                break;
            case 'PUT':
                if (isset($uri[3])) {
                    $this->updateFeedback($uri[3]);
                }
                break;
            case 'DELETE':
                if (isset($uri[3])) {
                    $this->deleteFeedback($uri[3]);
                }
                break;
            default:
                ResponseHelper::sendMethodNotAllowed("Méthode HTTP non supportée.");
                break;
        }
    }

    private function getFeedback($id) {
        $feedback = $this->feedbackService->getFeedbackById($id);
        if (!$feedback) {
            ResponseHelper::sendNotFound("Feedback introuvable.");
        } else {
            ResponseHelper::sendResponse($feedback);
        }
    }

    private function getAllFeedbacks() {
        $feedbacks = $this->feedbackService->getAllFeedbacks();
        ResponseHelper::sendResponse($feedbacks);
    }

    private function createFeedback() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $this->feedbackService->saveFeedback($data);
        ResponseHelper::sendResponse(['message' => 'Feedback créé avec succès', 'id' => $id], 201);
    }

    private function updateFeedback($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->feedbackService->saveFeedback(array_merge(['id_feedback' => $id], $data));
        ResponseHelper::sendResponse(['message' => 'Feedback mis à jour avec succès']);
    }

    private function deleteFeedback($id) {
        $this->feedbackService->deleteFeedback($id);
        ResponseHelper::sendResponse(['message' => 'Feedback supprimé avec succès']);
    }
}
