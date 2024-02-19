<?php
// file: api/src/Services/UserService.php
require_once 'Repository/UserRepository.php';

class UserService {
    private $userRepository;

    public function __construct($db) {
        $this->userRepository = new UserRepository($db);
    }

    public function addUser($userData) {
        return $this->userRepository->addUser($userData);
    }

    public function updateUser($id, $userData) {
        $this->userRepository->updateUser($id, $userData);
    }

    public function deleteUser($id) {
        $this->userRepository->deleteUser($id);
    }

    public function getUser($id) {
        return $this->userRepository->getUserById($id);
    }

    public function getAllUsers() {
        return $this->userRepository->getAllUsers();
    }
}
?>