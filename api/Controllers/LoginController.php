<?php
// Path: api/Controllers/LoginController.php

class LoginController {
    private $loginService;
    private $responseHelper;

    public function __construct(LoginService $loginService, ResponseHelper $responseHelper) {
        $this->loginService = $loginService;
        $this->responseHelper = $responseHelper;
    }

    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['email']) || !isset($data['mot_de_passe'])) {
            $this->responseHelper->sendResponse(["message" => "Email et mot de passe sont requis."], 400);
        }

        $email = $data['email'];
        $password = $data['mot_de_passe'];

        $user = $this->loginService->login($email, $password);
        
        if ($user) {
            $this->responseHelper->sendResponse($user);
        } else {
            $this->responseHelper->sendResponse(["message" => "Email ou mot de passe incorrect."], 401);
        }
    }
}
?>
