<?php

    include_once 'product_list.php';

    $product_id = $_GET['id'];

    $product = null;

    foreach ($products as $prod) {
        if ($prod['id'] == $product_id) {
            $product = $prod;
        }
    }

    echo json_encode($product);

?>