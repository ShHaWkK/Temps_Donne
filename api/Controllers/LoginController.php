<?php
require_once './Services/LoginService.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/UserRepository.php';
require_once './Exceptions/AuthenticationException.php';
require_once './Exceptions/RoleException.php';
require_once './Exceptions/StatusException.php';

class LoginController {
    private $userService;
    private $loginService;
    private $loginRepository;
    private $db;
    public function __construct() {
        $this->db = connectDB();
        $this->loginService=new LoginService($this->db);
        $this->loginRepository=new LoginRepository($this->db);
    }

    public function login() {
        try {
            // Check if a session is already open, continue if not
            $userId = $this->checkSession();

            $json = file_get_contents("php://input");
            $credentials = json_decode($json, true);

            if (!$userId) {
                $user = $this->loginService->authenticate($credentials['email'], $credentials["password"], $credentials["role"]);

                $session_token = $this->generateSessionToken();

                $_SESSION['session_token'] = $session_token;

                $this->storeSessionToken($user['ID_Utilisateur'], $session_token);

                $_SESSION['session_token'] = $session_token;

                $cookie_success = setcookie('session_token', $session_token, time() + 86400, '/');
                if (!$cookie_success) {
                    //echo("Failed to set session token cookie.");
                }
            }

            // Construct successful response
            $response = [
                'status' => 'success',
                'message' => 'Authentication successful.',
                'user_id' => $user['ID_Utilisateur'],
                'session_token' => $session_token ?? $_SESSION['session_token'] // Use existing token if available
            ];

            // Send response
            http_response_code(200);
            ResponseHelper::sendResponse($response);
            header('Location: .php');
            exit();
        } catch (RoleException $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        } catch (AuthenticationException $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], 401);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], 500);
        }
    }


    function generateSessionToken($length = 32) {
        $random_bytes = random_bytes($length);
        $token = bin2hex($random_bytes);
        return $token;
    }


    public function checkSession() {
        if (!isset($_COOKIE['session_token'])) {
            // No session token found in the request, return null
            return null;
        }

        $session_token = $_COOKIE['session_token'];

        // Retrieve session token from the database using your repository
        $userId = $this->loginRepository->getUserIdBySessionToken($session_token);

        if (!$userId) {
            // Session token not found in the database or expired, return null
            return null;
        }

        // Session token is valid, return the user ID
        return $userId;
    }

    public function logout() {
        // Détruire la session côté serveur
        session_destroy();

        // Supprimer le cookie de session côté client
        setcookie('session_token', '', time() - 3600, '/');

        http_response_code(200);
        ResponseHelper::sendResponse(['message' => 'Déconnexion réussie.']);
    }

    private function storeSessionToken($id, $session_token)
    {
        $this->loginRepository->storeSessionToken($id, $session_token);
    }

}
?>