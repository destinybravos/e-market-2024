<?php

    header('Content-Type: application/json');

    include_once 'product_list.php';


    echo json_encode($products);

?>