<?php
    header("Access-Control-Allow-Headers: Authorization");

    $headers = null;

    // Check for Authorization header on the global server varaible $_SERVER and assign it to headers
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) { // If Authorization not found, search for HTTP_AUTHORIZATION
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } 
    elseif (function_exists('apache_request_headers')) { // If HTTP_AUTHORIZATION not found, check if apache_request_headers function exists
        $requestHeaders = apache_request_headers();
        
        if (isset($requestHeaders['Authorization'])) { // Check if the Authorization header exists on the apache_request_headers function
            $headers = trim($requestHeaders['Authorization']);
        }
    }

    // If at this point, the $headers variable is still null, throw an exception for unauthorized access.
    if ($headers == null) {
        throw new Exception("Request Unauthorized", 401);
    }

    // Extract token from Authorization header
    list($scheme, $token) = explode(' ', $headers, 2);  // Split by space

    // Validate scheme (should be "Bearer")
    if (strtolower($scheme) !== 'bearer') {
        throw new Exception('Invalid authorization scheme', 401);
    }

    $auth_user = verifyUser($token, $conn);

    // Validate Authorized User
    if ($auth_user == null) {
        throw new Exception('User Unauthorized', 401);
    }

    function verifyUser($token, $conn){
        $sqlStatement = "SELECT * FROM access_tokens WHERE token = '$token'";
        $executeQuery = $conn->query($sqlStatement);
        if ($executeQuery->num_rows > 0) {
            $authRecord = $executeQuery->fetch_assoc();
            $email = base64_decode($token);
            if ($email == $authRecord['email']) {
                return getUserByEmail($email, $conn);
            }
        }

        return null;
    }

    function getUserByEmail($email, $conn){
        $sqlStatement = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }




?>