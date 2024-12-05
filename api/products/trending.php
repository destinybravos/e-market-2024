<?php

header('Content-Type: application/json');

$trendings = [
    [
        'category' => 'gamee tokens',
        'name' => 'iphone 12.',
        'price' => 230000,
        'description' => '',
        'rating' => 4,
        'discount' => 30,
        'image' => 'https://www-konga-com-res.cloudinary.com/image/upload/w_250,f_auto,fl_lossy,dpr_auto,q_auto/v1678695216/contentservice/Power.jpg_rJ_ViL2kh.jpg'
    ],
    [
        'category' => 'Test tokens',
        'name' => 'samsung Iwatch 12gen.',
        'price' => 4000,
        'description' => '',
        'rating' => 4,
        'discount' => 30,
        'image' => 'http://localhost/e-market-2024/app/images/gad1.avif'
    ],
    [
        'category' => 'Test tokens',
        'name' => 'Iwatch 12gen.',
        'price' => 2300,
        'description' => '',
        'rating' => 4,
        'discount' => 30,
        'image' => 'http://localhost/e-market-2024/app/images/gad1.avif'
    ],
];


echo json_encode($trendings);

?>