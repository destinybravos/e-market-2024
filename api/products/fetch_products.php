<?php
header('Content-Type: application/json'); 

include_once "../utils/connect.php";

$response = [];
$products = [];

try {
    include_once "../utils/AuthMiddleware.php";

    $sqlStmt = "SELECT * FROM products ORDER BY name ASC";
    $execQuery = $conn->query($sqlStmt);
    if ($execQuery->num_rows > 0) {
        while ($product = $execQuery->fetch_assoc()) {
            array_push($products, $product);
        }
    }


    if ($execQuery) {
        header('HTTP/1.1 200');
        $response['success'] = true;
        $response['products'] = $products;
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