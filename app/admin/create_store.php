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
    </script>
</head>

<body class="bg-background">

    <!-- Side Bar Section -->
    <section class="fixed h-dvh w-48 top-0">
        <?php include_once "components/admin_menu.html"; ?>
    </section>

    <!-- Main Section -->
    <main class="min-h-[4000px] ml-48">
        <!-- Stats and Search Section -->
        <section class="mr-60">
            
        </section>

        <!-- Profile Summary Section -->
        <section class="fixed h-dvh w-60 bg-white right-0 top-0">
            <?php include_once "components/profile_summary.html"; ?>
        </section>
    </main>
</body>

</html>