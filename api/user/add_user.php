<?php
header('Content-Type: application/json'); // Setting response header to return Json Format
include_once "../utils/connect.php"; // Database Connection


$response = []; // Creating an empty array for handling responses

/**
 * Recieving the data from the request 
 * Using (POST Request) as our request methods
 */
$firstname = $_POST['firstname'];
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : null;
$email = $_POST['email'];
$password = md5($_POST['password']);

try {
    // Validating if all need request parameters are present and not empty strings
    if((!isset($firstname) || $firstname == '') || (!isset($email) || $email == '') || (!isset($password) || $password == '')){
        throw new Exception("Missing field. Kindly check your inputs", 422);
    }


    /**
     * Check if the user already exist by trying to fetch the user with that email.
     * If it exists, throw an exception
     * if there is more than zero(0) records (num_rows), it simply mean someone is already using that email
     */
    $sqlStatment = "SELECT * FROM users WHERE email='$email'";
    $fetchRecords = $conn->query($sqlStatment);
    if ($fetchRecords->num_rows > 0) {
        throw new Exception("User with the email '$email' already exists.", 422);
    }

    /**
     * Saving the data to database
     * 1. Create and SQL Statement for data insertion
     * 2. Execute the SQL Statement
     */
    $sqlStatment = "INSERT INTO users(firstname, lastname, email, password) VALUES('$firstname', '$lastname', '$email', '$password')";
    $insertData = $conn->query($sqlStatment);
    if ($insertData) {
        header('HTTP/1.1 200');
        $response['success'] = true;
        $response['message'] = 'Record created successfully';
    } else {
        header('HTTP/1.1 500');
        $response['success'] = false;
        $response['message'] = 'Could not save user records';
        $response['error'] = $conn->error;
    }
    
} catch (\Throwable $th) {
    header('HTTP/1.1 ' . $th->getCode());
    $response['success'] = false;
    $response['message'] = $th->getMessage();
    $response['error'] = $th->getTrace();
}

echo json_encode($response);