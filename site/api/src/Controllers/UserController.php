<?php

// file: api/src/Controllers/UserController.php
require_once '../Services/UserService.php';

class UserController {
    private $userService;

    public function __construct($db) {
        $this->userService = new UserService($db);
    }

    public function addUser() {
        $userData = json_decode(file_get_contents("php://input"), true);
        $id = $this->userService->addUser($userData);
        echo json_encode(['message' => 'User created successfully', 'id' => $id]);
    }

    public function updateUser($id) {
        $userData = json_decode(file_get_contents("php://input"), true);
        $this->userService->updateUser($id, $userData);
        echo json_encode(['message' => 'User updated successfully']);
    }

    public function deleteUser($id) {
        $this->userService->deleteUser($id);
        echo json_encode(['message' => 'User deleted successfully']);
    }

    public function getUser($id) {
        $user = $this->userService->getUser($id);
        echo json_encode($user);
    }

    public function getAllUsers() {
        $users = $this->userService->getAllUsers();
        echo json_encode($users);
    }
}

?>