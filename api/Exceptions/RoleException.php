<?php
// File : api/Exceptions/RoleException.php

class RoleException extends Exception {
    protected $role;

    public function __construct($role, $message = "Role error", $code = 0, Exception $previous = null) {
        $this->role = $role;
        parent::__construct($message, $code, $previous);
    }

    public function getRole() {
        return $this->role;
    }

    public function errorMessage() {
        return "Error: {$this->message}, Required Role: {$this->role}";
    }
}
