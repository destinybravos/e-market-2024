<?php
header('Content-Type: application/json'); 

include_once "../utils/connect.php";
include_once "../utils/validate.php";

$response = [];

try {
    include_once "../utils/AuthMiddleware.php";
    validateInputsAdvanced($_POST, [
        'category_id' => ['required']
    ]);

    $category_id = $_POST['category_id'];

    $sqlStmt = "SELECT * FROM categories WHERE id = '$category_id'";
    $execQuery = $conn->query($sqlStmt);
    if ($execQuery->num_rows <= 0) {
        throw new Exception("Category does not exists", 404);
    }

    $sqlStmt = "DELETE FROM categories WHERE id = '$category_id'";
    $execQuery = $conn->query($sqlStmt);

    if ($execQuery) {
        header('HTTP/1.1 200');
        $response['success'] = true;
        $response['message'] = 'Category deleted successfully';
    } else {
        header('HTTP/1.1 500');
        $response['success'] = false;
        $response['message'] = 'Could not delete category';
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