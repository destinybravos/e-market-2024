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
    ?>

    <section class="my-3 px-6">
        <a href="products.php">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </section>

    <section class="max-w-6xl mx-auto py-16">
        <div class="flex flex-col md:flex-row items-start gap-8" id="product_details">

        </div>
    </section>

    <section>
        <?php
            include './components/products/related_products.html'
        ?>
    </section>


    <script>
        let baseURL = 'http://localhost/e-market-2024/api';

        let noOfStars = (rating) => {
            let starRating = Math.round(rating);
            let stars = '';

            for (let i = 0; i < starRating; i++) {
                stars += '<i class=" text-yellow-300 fa-solid fa-star"></i>';
            }

            for (let i = 0; i < (5 - starRating); i++) {
                stars += '<i class=" text-slate-300 fa-solid fa-star"></i>';
            }


            return stars;
        }

        let url = new URL(location.href) // create a new URL object
        let productId = url.searchParams.get('product_id'); // get the product id from the url parameter into the productId variable

        // Make an API request to fetch the details of the product with the productId
        fetch(`${baseURL}/products/single_product.php?id=${productId}`)
            .then((res) => res.json())
            .then((product) => {
                let details = `<div class="flex-1 w-1/2 overflow-hidden">
                                <img src="${product.image}" alt="Image" class="object-cover">
                            </div>

                            <div class="flex-1 w-1/2 py-6">
                                <h1 class="text-lg mb-3">${product.category}</h1>
                                <h1 class="text-3xl font-bold">${product.name}</h1>
                                <p>
                                    ${ noOfStars(product.rating) }
                                </p>
                                <hr class="my-6">
                                <div class="text-xl font-bold">
                                     &#8358; ${product.price - (product.price * (product.discount/100))}
                                </div>
                                <div class="text-sm line-through text-slate-400">
                                    ${ (product.discount > 0) ? `<small class="line-through text-sm text-slate-500">
                                        &#8358; ${product.price}
                                    </small>` : '' }
                                </div>
                            </div>`;

                document.getElementById('product_details').innerHTML = details;
            })
    </script>
</body>

</html>