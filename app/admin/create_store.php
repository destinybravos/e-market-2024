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
                    Create Store
                </div>
            </header>

            <div class="px-4 py-2">
                <form class="px-4 py-2 bg-white rounded-lg space-y-4" onsubmit="createShop(event)">
                    <input class="inpute" type="text" placeholder="Store Name" name="shop_name" required>
                    <input class="inpute" type="text" placeholder="Address" name="address">
                    <input class="inpute" type="text" placeholder="City Located" name="city">
                    <input class="inpute" type="text" placeholder="State" name="state">
                    <input class="inpute" type="text" placeholder="Contact Phone Number" name="phone">
                    <input class="inpute" type="text" placeholder="Any other description" name="description">
                    <div class="bg-secondary text-center text-white py-2 rounded-md">
                        <button class="max-w-full font-bold block w-full">
                            Create Shop
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Profile Summary Section -->
        <section class="fixed h-dvh w-60 bg-white right-0 top-0">
            <?php include_once "components/profile_summary.html"; ?>
        </section>
    </main>

    <script>
        let createShop = (ev) => {
            ev.preventDefault()
            let formData = new FormData(ev.target); // Created an empty JavaScript FormData() object

            fetch('http://localhost/e-market-2024/api/shop/add_shop.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Authorization': 'Bearer ' + getAuthToken()
                    }
                })
                .then((res) => res.json())
                .then((responseData) => {
                    if (responseData.success == true) {
                        updateUserShop(responseData.store);
                        location.href = 'index.php';
                    }
                })
                .catch((error) => {
                    console.error("Error", error);
                })

        }
    </script>
</body>

</html>