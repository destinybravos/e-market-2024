<?php
header('Content-Type: application/json'); 

include_once "../utils/connect.php";
include_once "../utils/validate.php";

$response = [];
$defaultImage = 'http://localhost/e-market-2024/api/products/default-product-image.png';

try {
    include_once "../utils/AuthMiddleware.php";

    validateInputsAdvanced($_POST, [
        'category_id' => ['required'],
        'shop_id' => ['required'],
        'product_name' => ['required'],
        'price' => ['required']
    ]);

    $category_id = $_POST['category_id'];
    $shop_id = $_POST['shop_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $discount = isset($_POST['discount']) ? $_POST['discount'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;


    // Validate Category if it exists
    $sqlStmt = "SELECT * FROM categories WHERE id = '$category_id'";
    $execQuery = $conn->query($sqlStmt);
    if ($execQuery->num_rows <= 0) {
        throw new Exception("Category does not exists", 404);
    }
    // Validate Shop if it exists
    $sqlStmt = "SELECT * FROM shops WHERE id = '$shop_id'";
    $execQuery = $conn->query($sqlStmt);
    if ($execQuery->num_rows <= 0) {
        throw new Exception("Shop does not exists", 404);
    }

    if (isset($_FILES['image']) && !empty($_FILES['image'])) {
        // Process the image
        $temp_name = $_FILES['image']['tmp_name'];
        $image_name = str_replace(' ', '_', $_FILES['image']['name']);
        if(!file_exists('images/')){
            mkdir('images/');
        }
        $storagePath = 'images/' . time() . $image_name;
        if (move_uploaded_file($temp_name, $storagePath)) {
            $image = 'http://localhost/e-market-2024/api/products/' . $storagePath;
        }else{
            throw new Exception("Could not upload product image", 500);
        }
    }else{
        $image = $defaultImage;
    }
    

    $sqlStmt = "INSERT INTO products(category_id, shop_id, name, price, discount, description, image) 
            VALUES('$category_id', '$shop_id', '$product_name', '$price', '$discount', '$description', '$image')";
    $execQuery = $conn->query($sqlStmt);

    if ($execQuery) {
        header('HTTP/1.1 200');
        $response['success'] = true;
        $response['message'] = 'Product Record created successfully';
    } else {
        header('HTTP/1.1 500');
        $response['success'] = false;
        $response['message'] = 'Could not save product records';
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