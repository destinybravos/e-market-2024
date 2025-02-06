<?php

    include_once "connect.php";

    // Create User Table
    $sqlStatement = "CREATE TABLE IF NOT EXISTS users(
        id INT(6) PRIMARY KEY AUTO_INCREMENT,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30),
        email VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(100) NOT NULL,
        created_at DATETIME DEFAULT(CURRENT_TIMESTAMP)
    )";
    $conn->query($sqlStatement);

    // Create Shop Tables
    $sqlStatement = "CREATE TABLE IF NOT EXISTS shops(
        id INT(6) PRIMARY KEY AUTO_INCREMENT,
        user_id INT(6) NOT NULL,
        shop_name VARCHAR(30) NOT NULL,
        address VARCHAR(50),
        city VARCHAR(50),
        state VARCHAR(50),
        phone VARCHAR(50) UNIQUE,
        description TEXT,
        created_at DATETIME DEFAULT(CURRENT_TIMESTAMP),
        CONSTRAINT shop_owner FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $conn->query($sqlStatement);

    // Create categories Tables
    $sqlStatement = "CREATE TABLE IF NOT EXISTS categories(
        id INT(6) PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        description TEXT
    )";
    $conn->query($sqlStatement);

    // Create products Tables
    $sqlStatement = "CREATE TABLE IF NOT EXISTS products(
        id INT(6) PRIMARY KEY AUTO_INCREMENT,
        category_id INT(6) NOT NULL,
        shop_id INT(6) NOT NULL,
        name VARCHAR(100) NOT NULL,
        price DOUBLE(10, 2),
        description MEDIUMTEXT,
        discount INT(4),
        image VARCHAR(1000),
        created_at DATETIME DEFAULT(CURRENT_TIMESTAMP),
        CONSTRAINT product_category FOREIGN KEY (category_id) REFERENCES categories(id),
        CONSTRAINT product_shop FOREIGN KEY (shop_id) REFERENCES shops(id)
    )";
    $conn->query($sqlStatement);

    // create Personal Access Token table structure if not exist
    $sqlAccessToken = "CREATE TABLE IF NOT EXISTS access_tokens (
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT(CURRENT_TIMESTAMP),
        expires_at DATETIME DEFAULT(NULL)
    )";

    $conn->query($sqlAccessToken);


    echo "All table created successfully <br>";

?>