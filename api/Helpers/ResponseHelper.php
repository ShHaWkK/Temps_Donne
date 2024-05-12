<?php

class ResponseHelper {
    public static function sendResponse($data, $status = 200) {
        if (!headers_sent()) {
            header("Content-Type: application/json");
            header("HTTP/1.1 " . $status);
        }
        echo json_encode($data);
    }

    public static function sendNotFound($message = "Not Found") {
        self::sendResponse(["message" => $message], 404);
    }
}
?>
