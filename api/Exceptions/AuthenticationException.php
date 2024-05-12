<?php
// File : api/Exceptions/AuthenticationException.php

class AuthenticationException extends Exception {
    public function errorMessage() {
        return "Authentication error: {$this->message}";
    }
}
