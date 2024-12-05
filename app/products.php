<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Market</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="./assets/fa-icons/css/all.css">
</head>
<body class="">
    <?php 
        include_once './components/site_header.html';
        include_once './components/products/trending.html';
        include_once './components/products/latest.html';
        include_once './components/products/featured.html';
        include_once './components/products/all.html';
    ?>
</body>
</html>