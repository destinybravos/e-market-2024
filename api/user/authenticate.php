<?php
header('Content-Type: application/json');
include_once '../utils/validate.php';
include_once "../utils/connect.php"; 

$response = []; // Creating an empty array for handling responses


try {
    validateInputsAdvanced($_POST, [
        'email' => ['required', 'email'],
        'password' => ['required']
    ]);

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Create MySQL query to fetch the user
    $sqlStatement = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $executeQuery = $conn->query($sqlStatement); // Execute the Query

    if ($executeQuery->num_rows > 0) {
        $user = $executeQuery->fetch_assoc(); // Fetch the user record
        header('HTTP/1.1 200');
        $response['success'] = true;
        $response['message'] = "User authentication successfull";
        $response['user'] = $user;
    }else{
        header('HTTP/1.1 404');
        $response['success'] = false;
        $response['message'] = "Invalid email or password.";
        $response['error'] = [];
    }

} catch (\Throwable $th) {
    header('HTTP/1.1 ' . $th->getCode());
    $response['success'] = false;
    $response['message'] = $th->getMessage();
    $response['error'] = $th->getTrace();
}

echo json_encode($response);
