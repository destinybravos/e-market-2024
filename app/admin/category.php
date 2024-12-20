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
                    Manage Categories
                </div>
            </header>

            <div class="px-4 py-2 flex gap-4 justify-between items-start">
                <!-- Category form -->
                <aside class="flex-1">
                    <h1 class="font-semibold text-xl mb-2">
                        Add Category
                    </h1>
                    <form class="px-4 py-2 bg-white rounded-lg space-y-4" onsubmit="addCategory(event)">
                        <input class="inpute" type="text" placeholder="Category" name="category" required>
                        <input class="inpute" type="text" placeholder="Any other description" name="description">
                        <div class="bg-secondary text-center text-white py-2 rounded-md">
                            <button class="max-w-full font-bold block w-full">
                                Add Category
                            </button>
                        </div>
                    </form>
                </aside>
                <!-- Category List -->
                <aside class="w-56 bg-white min-h-10">
                    <h1 class="font-semibold text-xl mb-2 px-4 py-2">
                        Category List
                    </h1>

                    <ul id="cat_list">
                        
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
        let addCategory = (ev) => {
            ev.preventDefault()
            let formData = new FormData(ev.target); // Created an empty JavaScript FormData() object

            fetch('http://localhost/e-market-2024/api/shop/add_category.php', {
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
                        fetchCategory();
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
            let listItems = '';

            categories.forEach((category) => {
                listItems += `<li class="px-4 py-2 odd:bg-slate-200 flex justify-between items-center">
                            <span>
                                ${category.name}
                            </span>
                            <button class="text-red-500" onclick="deleteCategory(${category.id})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </li>`;

            })

            // console.log('products', products);
            document.getElementById('cat_list').innerHTML = listItems;
        }

        let deleteCategory = (id) => {
            let data = new FormData();
            data.append('category_id', id);

            fetch('http://localhost/e-market-2024/api/shop/delete_category.php', {
                    method: 'POST',
                    body: data,
                    headers: {
                        'Authorization': 'Bearer ' + getAuthToken()
                    }
                })
                .then((res) => res.json())
                .then((responseData) => {
                    alert(responseData.message)
                    fetchCategory();
                })
                .catch((error) => {
                    console.error("Error", error);
                })
        }
    </script>
</body>

</html>