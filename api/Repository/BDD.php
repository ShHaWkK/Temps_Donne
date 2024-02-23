<?php

include_once './Services/globalFunctions.php';

// Function to handle exiting with a message
function exit_with_message($message) {
    echo json_encode(['error' => $message]);
    exit;
}


// Function to connect to the database
function connectDB() {
    $host = 'db';
    $port = 5432;
    $dbname = 'temps';
    $user = 'root';
    $password = $_ENV['MYSQL_ROOT_PASSWORD'];

    try {
        $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password", null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        exit_with_message("ERROR: Connection to the database failed: " . $e->getMessage());
    }
    return $db;
}

// Function to select data from the database
function selectDB($table, $columns, $condition = -1, $additionalMessage = NULL){
    checkData($table, $columns, -10, $condition);
    $db = connectDB();
    $dbRequest = $condition == -1 ? "SELECT $columns FROM $table" : "SELECT $columns FROM $table WHERE $condition";

    try {
        $result = $db->prepare($dbRequest);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit_with_message("ERROR: " . $e->getMessage());
    }
}

// Function to check input data before performing database operations
function checkData($table, $columnArray, $columnData, $condition){
    // Basic check, should be expanded based on actual needs
    if ($table === -10 || $columnArray === -10 || $columnData === -10 || $condition === -10) {
        exit_with_message('Please provide all required parameters.');
    }
    // Additional checks can be added here as per your validation rules

}

function insertDB($table, $columnArray, $columnData, $returningData = null){
    checkData($table, $columnArray, $columnData, -10);
    $db = connectDB();

    $columns = implode(", ", $columnArray);
    $placeholders = implode(", ", array_fill(0, count($columnData), '?'));

    $dbRequest = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    if ($returningData) {
        $dbRequest .= " RETURNING $returningData";
    }

    try {
        $stmt = $db->prepare($dbRequest);
        $stmt->execute($columnData);
        return $returningData ? $stmt->fetch(PDO::FETCH_ASSOC) : true;
    } catch (PDOException $e) {
        exit_with_message("PDO error :" . $e->getMessage());
    }
}

// Function to update data in the database
function updateDB($table, $columnArray, $columnData, $condition)
{
    checkData($table, $columnArray, $columnData, $condition);

    $db = connectDB();

    $sets = [];
    foreach ($columnArray as $column) {
        $sets[] = "$column = ?";
    }
    $setString = implode(", ", $sets);

    $dbRequest = "UPDATE $table SET $setString WHERE $condition";

    try {
        $result = $db->prepare($dbRequest);
        $result->execute($columnData);
        return true;
    } catch (PDOException $e) {
        exit_with_message("PDO error :" . $e->getMessage());
    }
}


// Function to delete data from the database
function deleteDB($table, $condition, $conditionValues = [])
{
    checkData($table, -10, -10, $condition);

    $db = connectDB();

    $dbRequest = "DELETE FROM $table WHERE $condition";

    try {
        $stmt = $db->prepare($dbRequest);
        $stmt->execute($conditionValues);
        return true;
    } catch (PDOException $e) {
        exit_with_message("PDO error :" . $e->getMessage());
    }
}

?>