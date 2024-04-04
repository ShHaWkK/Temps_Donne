<?php
require_once './Services/UserService.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/UserRepository.php';
require_once './Exceptions/AuthenticationException.php';
require_once './Exceptions/RoleException.php';

use \Firebase\JWT\JWT;

class LoginController {
    private $userService;

    public function __construct() {
        $this->userService = new UserService(new UserRepository(connectDB()));
    }

    public function login() {
        try {
            $json = file_get_contents("php://input");
            $credentials = json_decode($json, true);
            $this->validateCredentials($credentials);

            $user = $this->userService->authenticate($credentials['email'], $credentials['password'], $credentials['role']);
            $token = $this->generateToken($user);

            ResponseHelper::sendResponse(['message' => 'Authentication successful', 'token' => $token]);
        } catch (RoleException $e) {
            ResponseHelper::sendResponse(['error' => $e->errorMessage()], 403);
        } catch (AuthenticationException $e) {
            ResponseHelper::sendResponse(['error' => $e->errorMessage()], 401);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function validateCredentials($credentials) {
        if (!isset($credentials['email']) || !isset($credentials['password']) || !isset($credentials['role'])) {
            throw new AuthenticationException('Email, password, and role are required');
        }
    }

    private function generateToken($user) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // token expires in 1 hour

        $payload = [
            'userid' => $user['id'], 
            'email' => $user['email'],
            'iat' => $issuedAt,
            'exp' => $expirationTime
        ];
    
        $jwtSecretKey = getenv('JWT_SECRET_KEY'); // make sure you have defined this in your .env file
    
        return JWT::encode($payload, $jwtSecretKey, 'HS256');
    }
}
?>

