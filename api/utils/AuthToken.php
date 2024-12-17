<?php
    
    // include_once 'connect.php'; // Include the connection object
    $conn = new MySQLi("localhost", "root", "", "school_mgt");
    define('CONNECT', $conn);

    // Function to generate a random string for token payload
    function generateRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    // Function to generate a JWT (JSON Web Token)
    function generateToken($userId, $expiration = 3600) { // Default expiration: 1 hour
        $randomString = generateRandomString();
        $encryptedUserid = base64_encode($userId);
        return $randomString . "." . $encryptedUserid;
    }

    function saveAccessToken($email) {
        $expiry = time() + 60*60*24;
        $token = generateToken($email, $expiry);

        // Save Token
        if (userEmailExists($email, CONNECT)) {
            $sql = "UPDATE access_tokens SET token ='$token', expires_at='$expiry' WHERE email = '$email'";
        } else {
            $sql = "INSERT INTO access_tokens(email, token, expires_at) VALUES('$email','$token','$expiry')";
        }

        $result = CONNECT->query($sql);
        if ($result) {
            return $token;
        } else {
            return null;
        }
    }

    function validateToken($token, $email){

        $valid = false; // Set the initial value of valid to false

        $sql = "SELECT * FROM access_tokens WHERE email = '$email' AND token='$token'";
        $result = CONNECT->query($sql);

        if ($result->num_rows > 0) {
            $valid = true;
        }

        return $valid;
    }

    function verifyToken($token) {

        $parts = explode('.', $token);
        $payload = $parts;
        $userEmail = base64_decode($parts[1]);

        if (validateToken($token, $userEmail) == false) {
            throw new Exception("Invalid authorization token", 401);
        }

        // Create an authorization object
        $auth = new stdClass();

        // save the access toke on the object 
        $auth->token = $token;

        // save the user data into the auth object too
        $auth->user = fetchUserData($userEmail);

        return $auth; // Return the authentication object
    }

    function verifySimpleToken($token) {
        $userEmail = base64_decode($token);

        if (userEmailExists($userEmail) == false) {
            throw new Exception("Invalid authorization token", 401);
        }

        // Create an authorization object
        $auth = new stdClass();

        // save the access toke on the object 
        $auth->token = $token;

        // save the user data into the auth object too
        $auth->user = fetchUserData($userEmail);

        return $auth; // Return the authentication object
    }

    function deleteToken($token) {
        $deleted = false;

        $parts = explode('.', $token);
        $payload = $parts;
        $userEmail = base64_decode($parts[1]);

        if (validateToken($token, $userEmail) == false) {
            throw new Exception("Invalid authorization token", 401);
        }

        $sql = "DELETE FROM access_tokens WHERE email = '$userEmail' AND token='$token'";
        $result = CONNECT->query($sql);
        if ($result) {
            $deleted = true;
        }

        return $deleted;
    }    

    function fetchUserData($email){
        $sql = "SELECT id, firstname, lastname, email, photo, role, email_verified_at, phone, gender, bio FROM users WHERE email = '$email'";
        $result = CONNECT->query($sql);
        return $result->fetch_assoc();
    }

    function userEmailExists($email) {
        $sql = "SELECT * FROM access_tokens WHERE email = '$email'";
        $result = CONNECT->query($sql);
        return $result->num_rows > 0;
    }

    
?>