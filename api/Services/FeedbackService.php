<?php

require_once './Repository/FeedbackRepository.php';

class FeedbackService {
    private $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository) {
        $this->feedbackRepository = $feedbackRepository;
    }

    public function getFeedbackById($id) {
        return $this->feedbackRepository->findById($id);
    }

    public function getAllFeedbacks() {
        return $this->feedbackRepository->findAll();
    }

    public function saveFeedback($feedback) {
        return $this->feedbackRepository->save($feedback);
    }

    public function deleteFeedback($id) {
        $this->feedbackRepository->delete($id);
    }
}
