<?php
header('Content-Type: application/json'); 

include_once "../utils/connect.php";
include_once "../utils/validate.php";

$response = [];

try {
    include_once "../utils/AuthMiddleware.php";

    validateInputsAdvanced($_POST, [
        'category' => ['required']
    ]);

    $category_name = $_POST['category'];
    $description = isset($_POST['description']) ? $_POST['description'] : null;

    $sqlStmt = "INSERT INTO categories(name, description) VALUES('$category_name', '$description')";
    $execQuery = $conn->query($sqlStmt);

    if ($execQuery) {
        header('HTTP/1.1 200');
        $response['success'] = true;
        $response['message'] = 'Category Record created successfully';
    } else {
        header('HTTP/1.1 500');
        $response['success'] = false;
        $response['message'] = 'Could not save category records';
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