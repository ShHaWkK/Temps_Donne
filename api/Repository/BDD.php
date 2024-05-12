<?php
//file : api/Repository/BDD.php
require_once './Services/globalFunctions.php';


// Function to connect to the database
function connectDB() {
    $host = 'db';
    $port = '3306';
    $dbname = 'temps';
    $user = 'root';
    $password = 'toor';

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
function checkData($table = -10, $columnArray = -10, $columnData = -10, $condition = -10){
    $bool = false;

    $sentence = "Please specifie ";
    $addSentence = "";
    if (empty($table)){
        $bool = true;
        $sentence .= "the table, ";
    }
    if (empty($columnArray)){
        $bool = true;
        $sentence .= "the colums, ";
    }
    if (empty($columnData)){
        $bool = true;
        $sentence .= "the data, ";
    }

    if (empty($condition))
    {
        $bool = true;
        $sentence .= "the condition, ";
        $addSentence .= " To apply no condition, plz give -1.";
    }

    if ($bool == true){
        $sentence .= "(to execute the function, each args has to be not null).". $addSentence;
        exit_with_message($sentence);
    }

    if (!checkMsg($condition, "=") && $condition != -1 && $condition != -10){
        exit_with_message('Plz enter a valid condition like : columnName=data'. $addSentence);
    }
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

    //--------------------------------------------//

    // Function to handle exiting with a message
    function exit_with_message($message) {
        echo json_encode(['error' => $message]);
        exit;
    }


}


?>