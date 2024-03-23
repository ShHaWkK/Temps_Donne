<?php
// File : api/Controllers/LoginController.php

require_once './Services/LoginService.php';
require_once './Helpers/ResponseHelper.php';

class LoginController {
    private $loginService;

    public function __construct() {
        $this->loginService = new LoginService();
    }

    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $sessionData = $this->loginService->authenticate($data['email'], $data['mot_de_passe']);
            ResponseHelper::sendResponse([
                'message' => 'Connexion réussie',
                'sessionData' => $sessionData
            ]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }
}

?>
