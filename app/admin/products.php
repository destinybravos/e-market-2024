<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Market Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../assets/fa-icons/css/all.css">
    <script src="./js/AuthServices.js"></script>
    <script>
        let loginState = localStorage.getItem('is_logded_in');
        if (loginState == null || loginState == undefined || loginState == 'false') {
            window.location.href = 'login.html';
        }

        let user = getUserObject(); // Get the user details from the AuthServices
    </script>
</head>

<body class="bg-background">

    <!-- Side Bar Section -->
    <section class="fixed h-dvh w-48 top-0">
        <?php include_once "components/admin_menu.html"; ?>
    </section>

    <!-- Main Section -->
    <main class="min-h-[4000px] ml-48">
        <!-- Create Store Form Section -->
        <section class="mr-60">
            <header class=" py-5 flex justify-start items-center px-4">
                <div class="text-2xl font-semibold flex-1">
                    Manage Products
                </div>
            </header>

            <div class="px-4 py-2 flex gap-4 justify-between items-start">
                <!-- Category form -->
                <aside class="flex-1">
                    <h1 class="font-semibold text-xl mb-2">
                        Add Category
                    </h1>
                    <form class="px-4 py-2 bg-white rounded-lg space-y-4" onsubmit="saveProduct(event)" enctype="multipart/form-data">
                        <input class="inpute" type="file" placeholder="Product Name" name="image" accept="image/*" multiple>
                        <select class="inpute" id="cat_options" name="category_id" required>

                        </select>
                        <input class="inpute" type="text" placeholder="Product Name" name="product_name">
                        <input class="inpute" type="number" placeholder="Price" name="price">
                        <input class="inpute" type="number" placeholder="Discount (if any)" name="discount">
                        <textarea class="inpute" type="text" placeholder="Any other description" name="description"></textarea>
                        <div class="bg-secondary text-center text-white py-2 rounded-md">
                            <button class="max-w-full font-bold block w-full">
                                <i class="fas fa-save"></i> Save Product
                            </button>
                        </div>
                    </form>
                </aside>
                <!-- Category List -->
                <aside class="w-56 bg-white min-h-10">
                    <h1 class="font-semibold text-xl mb-2 px-4 py-2">
                        Product List
                    </h1>

                    <ul id="prod_list">
                        
                    </ul>
                </aside>
            </div>
        </section>

        <!-- Profile Summary Section -->
        <section class="fixed h-dvh w-60 bg-white right-0 top-0">
            <?php include_once "components/profile_summary.html"; ?>
        </section>
    </main>

    <script>
        let saveProduct = (ev) => {
            ev.preventDefault()
            let formData = new FormData(ev.target); // Created an empty JavaScript FormData() object
            formData.append('shop_id', user.store?.id);

            fetch('http://localhost/e-market-2024/api/products/add_product.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Authorization': 'Bearer ' + getAuthToken()
                    }
                })
                .then((res) => res.json())
                .then((responseData) => {
                    if (responseData.success == true) {
                        ev.target.reset();
                        fetchProducts();
                    }else{
                        alert(responseData.message)
                    }
                })
                .catch((error) => {
                    console.error("Error", error);
                })

        }

        let fetchCategory = () => {
            fetch('http://localhost/e-market-2024/api/shop/fetch_category.php', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + getAuthToken()
                    }
                })
                .then((res) => res.json())
                .then((responseData) => {
                    displayCategories(responseData.categories)
                })
                .catch((error) => {
                    console.error("Error", error);
                })

        }
        fetchCategory();

        let displayCategories = (categories) => {
            let listItems = '<option value=""> Select Category </option>';

            categories.forEach((category) => {
                listItems += `<option value="${category.id}"> ${category.name} </option>`;

            })

            // console.log('products', products);
            document.getElementById('cat_options').innerHTML = listItems;
        }

        let fetchProducts = () => {
            fetch('http://localhost/e-market-2024/api/products/fetch_products.php', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + getAuthToken()
                    }
                })
                .then((res) => res.json())
                .then((responseData) => {
                    displayProducts(responseData.products)
                })
                .catch((error) => {
                    console.error("Error", error);
                })

        }
        fetchProducts();

        let displayProducts = (products) => {
            let listItems = '';
            products.forEach((product) => {
                listItems += `<li class="px-4 py-2 odd:bg-slate-200 flex justify-between items-center">
                            <div> <img src="${product.image}" class="w-10" /> </div>
                            <span>
                                ${product.name}
                            </span>
                            <button class="text-red-500" onclick="deleteCategory(${product.id})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </li>`;

            })

            // console.log('products', products);
            document.getElementById('prod_list').innerHTML = listItems;
        }

        let deleteProduct = (id) => {
            let data = new FormData();
            data.append('product_id', id);

            // Send the request to delete product
        }
    </script>
</body>

</html>