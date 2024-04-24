<?php
require_once './Services/LoginService.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/UserRepository.php';
require_once './Exceptions/AuthenticationException.php';
require_once './Exceptions/RoleException.php';

class LoginController {
    private $userService;

    public function login() {
        try {
            $json = file_get_contents("php://input");
            $credentials = json_decode($json, true);

            $loginService = new LoginService();
            $loginService->authenticate($credentials['email'], $credentials["password"]);
            //$user = $this->userService->authentificate($credentials['email'], $credentials['password']);

        } catch (RoleException $e) {
            exit_with_message($e->errorMessage(), 403);
        }
    }
}
?>

