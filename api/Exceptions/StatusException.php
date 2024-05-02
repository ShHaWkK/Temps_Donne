<?php
// File : api/Exceptions/AuthenticationException.php

class StatusException extends Exception {
    public function errorMessage() {
        return "Status Error: {$this->message}";
    }
}
