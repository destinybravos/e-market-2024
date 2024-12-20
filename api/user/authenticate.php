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
        $accessToken = createAccessToken($user['email'], $conn);

        // Verify if access token was stored
        if ($accessToken == null) {
            throw new Exception("Personal Access token could not be created", 500);
        }

        // Get the shop of the user
        $user['store'] = getUserShop($user['id'], $conn);

        header('HTTP/1.1 200');
        $response['success'] = true;
        $response['message'] = "User authentication successfull";
        $response['user'] = $user;
        $response['auth_token'] = $accessToken;
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


function createAccessToken($email, $conn){
    $token = base64_encode($email);
    $sqlStatement = "INSERT INTO access_tokens(email, token) VALUES('$email', '$token')";
    $executeQuery = $conn->query($sqlStatement);
    if ($executeQuery) {
        return $token;
    }
    return null;
}

function getUserShop($id, $conn){
    $sqlStatement = "SELECT * FROM shops WHERE user_id='$id'";
    $result = $conn->query($sqlStatement);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}
