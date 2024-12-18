<?php
header('Content-Type: application/json'); 

include_once "../utils/connect.php";

$response = [];
$products = [];

try {
    $sqlStmt = "SELECT * FROM products ORDER BY name ASC";
    $execQuery = $conn->query($sqlStmt);
    if ($execQuery->num_rows > 0) {
        while ($product = $execQuery->fetch_assoc()) {
            $product['category'] = getProductCategory($product['category_id'], $conn);
            $product['no_reviews'] = getReviews()['no_reviews'];
            $product['rating'] = getReviews()['rating'];
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

function getProductCategory($id, $conn){
    $sqlStatement = "SELECT * FROM categories WHERE id='$id'";
    $result = $conn->query($sqlStatement);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

function getReviews(){
    return [
        'rating' => 0,
        'no_reviews' => 0
    ];

    return null;
}
?>