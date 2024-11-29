<?php

    header('Content-Type: application/json');

    $products = [
        [
            'category' => 'Phone gadgets',
            'name' => 'samsung Iwatch 12gen.',
            'price' => 230000,
            'description' => '',
            'rating' => 4,
            'discount' => 30,
            'image' => 'http://localhost/e-market-2024/app/images/gad1.avif'
        ],
        [
            'category' => 'Beauty & Cosmetics',
            'name' => 'NIVEA Dry Comfort Roll-on For Women, 72h- 50ml (Pack Of 3)',
            'price' => 3500,
            'description' => '',
            'rating' => 5,
            'discount' => 0,
            'image' => 'https://ng.jumia.is/unsafe/fit-in/500x500/filters:fill(white)/product/64/9523401/1.jpg?5543'
        ],
        [
            'category' => 'Beauty & Cosmetics',
            'name' => 'Foreign Trade Piano Color Balayage Highlight Straight Bob Wig 10A 4x4 BOB 150 180 Density',
            'price' => 23000,
            'description' => '',
            'rating' => 3.5,
            'discount' => 25,
            'image' => 'https://ng.jumia.is/unsafe/fit-in/500x500/filters:fill(white)/product/01/8589733/1.jpg?0860'
        ],
        [
            'category' => 'Home Appliances',
            'name' => 'Home Rugs Living Bedroom Plush Rugs Grass Green',
            'price' => 22000,
            'description' => '',
            'rating' => 4.7,
            'discount' => 10,
            'image' => 'https://ng.jumia.is/unsafe/fit-in/500x500/filters:fill(white)/product/29/5857543/1.jpg?4692'
        ],
        [
            'category' => 'Phone gadgets',
            'name' => 'Protective Cover For Airpods Universal Headset Case Wireless Earphone Silicone Case',
            'price' => 13743,
            'description' => '',
            'rating' => 4,
            'discount' => 0,
            'image' => 'https://ng.jumia.is/unsafe/fit-in/500x500/filters:fill(white)/product/16/4812733/1.jpg?1146'
        ],
        [
            'category' => 'Phone gadgets',
            'name' => 'samsung Iwatch 12gen.',
            'price' => 230000,
            'description' => '',
            'rating' => 4,
            'discount' => 30,
            'image' => 'http://localhost/e-market-2024/app/images/gad1.avif'
        ],
        [
            'category' => 'Beauty & Cosmetics',
            'name' => 'NIVEA Dry Comfort Roll-on For Women, 72h- 50ml (Pack Of 3)',
            'price' => 3500,
            'description' => '',
            'rating' => 5,
            'discount' => 0,
            'image' => 'https://ng.jumia.is/unsafe/fit-in/500x500/filters:fill(white)/product/64/9523401/1.jpg?5543'
        ],
        [
            'category' => 'Beauty & Cosmetics',
            'name' => 'Foreign Trade Piano Color Balayage Highlight Straight Bob Wig 10A 4x4 BOB 150 180 Density',
            'price' => 23000,
            'description' => '',
            'rating' => 3.5,
            'discount' => 25,
            'image' => 'https://ng.jumia.is/unsafe/fit-in/500x500/filters:fill(white)/product/01/8589733/1.jpg?0860'
        ],
        [
            'category' => 'Home Appliances',
            'name' => 'Home Rugs Living Bedroom Plush Rugs Grass Green',
            'price' => 22000,
            'description' => '',
            'rating' => 4.7,
            'discount' => 10,
            'image' => 'https://ng.jumia.is/unsafe/fit-in/500x500/filters:fill(white)/product/29/5857543/1.jpg?4692'
        ],
        [
            'category' => 'Phone gadgets',
            'name' => 'Protective Cover For Airpods Universal Headset Case Wireless Earphone Silicone Case',
            'price' => 13743,
            'description' => '',
            'rating' => 4,
            'discount' => 0,
            'image' => 'https://ng.jumia.is/unsafe/fit-in/500x500/filters:fill(white)/product/16/4812733/1.jpg?1146'
        ],
    ];


    echo json_encode($products);

?>