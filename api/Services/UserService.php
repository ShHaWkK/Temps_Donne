<?php

include_once './Repository/UserRepository.php';
include_once './Models/UserModel.php';
// Inclure d'autres dépendances si nécessaire

class UserService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers() {
        return $this->userRepository->findAll();
    }

    public function registerUser(UserModel $user) {
        // Vérifiez si l'email est déjà utilisé
        if ($this->userRepository->findByEmail($user->email)) {
            throw new Exception("Un compte avec cet email existe déjà.");
        }

        // Validez et préparez les données utilisateur
        $user->hashPassword();
        $user->generateVerificationCode();
        $user->date_d_inscription = date('Y-m-d');
        $user->statut = true; // Ou false, selon la logique de votre application

        // Sauvegardez l'utilisateur dans la base de données
        return $this->userRepository->save($user);
    }

    public function authenticateUser($email, $password) {
        $user = $this->userRepository->findByEmail($email);

        if ($user && password_verify($password, $user->mot_de_passe)) {
            // Connectez l'utilisateur (par exemple, démarrez une session)
            $this->startUserSession($user);
            return $user;
        }

        // Gérez l'échec de l'authentification
        throw new Exception("Identifiants incorrects.");
    }

    private function startUserSession(UserModel $user) {
        session_start();
        $_SESSION['user'] = [
            'id' => $user->id_utilisateur,
            'email' => $user->email,
            'role' => $user->role
        ];
    }

    public function logout() {
        session_start();
        session_destroy();
    }
}
