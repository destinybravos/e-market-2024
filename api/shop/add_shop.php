<?php
header('Content-Type: application/json'); 

include_once "../utils/connect.php";
include_once "../utils/validate.php";

$response = [];

try {
    include_once "../utils/AuthMiddleware.php";

    validateInputsAdvanced($_POST, [
        'shop_name' => ['required']
    ]);

    $userId = $auth_user['id']; // User ID is comming from the AuthMiddleware
    $shop_name = $_POST['shop_name'];
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $city = isset($_POST['city']) ? $_POST['city'] : null;
    $state = isset($_POST['state']) ? $_POST['state'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;

    $sqlStmt = "INSERT INTO shops(user_id, shop_name, address, city, state, phone, description) 
            VALUES('$userId', '$shop_name', '$address', '$city', '$state', '$phone', '$description')";
    $execQuery = $conn->query($sqlStmt);

    if ($execQuery) {
        header('HTTP/1.1 200');
        $response['success'] = true;
        $response['message'] = 'Shop Record created successfully';
    } else {
        header('HTTP/1.1 500');
        $response['success'] = false;
        $response['message'] = 'Could not save shop records';
        $response['error'] = $conn->error;
    }

} catch (\Throwable $th) {
    header('HTTP/1.1 ' . $th->getCode());
    $response['success'] = false;
    $response['message'] = $th->getMessage();
    $response['error'] = $th->getTrace();
}

echo json_encode($response);
?>