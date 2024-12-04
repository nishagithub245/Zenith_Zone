<?php
session_start();
include "../Database_Connection/DB_Connection.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>ZenithZone</title>
    <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gray-200 font-poppins">
    <div class="wrapper relative">
        <!-- Hidden checkbox for sidebar toggle -->
        <input type="checkbox" id="btn" class="hidden" />

        <!-- Menu Button -->
        <label for="btn" class="menu-btn absolute left-5 top-3 bg-blue-500 text-white h-12 w-12 flex items-center justify-center rounded-full cursor-pointer">
            <i class="fas fa-bars"></i>
        </label>

        <!-- Sidebar -->
        <nav id="sidebar" class="fixed bg-gray-700 h-full w-64 left-[-270px] transition-all duration-300">
            <div class="flex justify-center items-center text-white text-3xl font-semibold py-5 bg-gradient-to-r from-blue-600 to-indigo-700">
                <!-- Link with Image and Text -->
                <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ? '../HomePage/Personalized_products.php' : '../HomePage/InitialPage1.php'; ?>" class="flex items-center space-x-3">
                    <!-- Image -->
                    <img src="../assets/images/logo/ZenithZone.png" alt="ZenithZone logo" class="h-16 sm:h-20" />
                    <!-- Text with custom font -->
                    <span class="font-poppins text-4xl sm:text-2xl">ZenithZone</span>
                </a>
            </div>
            <ul class="list-items">
                <li class="py-4 pl-10 sidebar-button" id="profile-btn">
                    <a href="javascript:void(0);" class="text-white text-lg flex items-center">
                        <i class="fas fa-user-circle"></i>
                        <span class="ml-4">Profile</span>
                    </a>
                </li>
                <li class="py-4 pl-10 sidebar-button" id="add-product-btn">
    <a href="javascript:void(0);" class="text-white text-lg flex items-center">
        <i class="fas fa-plus-circle"></i> <!-- Icon for add product -->
        <span class="ml-4">Add Product</span>
    </a>
</li>

                <li class="py-4 pl-10 sidebar-button" id="wallet-btn">
                    <a href="javascript:void(0);" class="text-white text-lg flex items-center">
                        <i class="fas fa-wallet"></i> <!-- Wallet icon -->
                        <span class="ml-4">My Wallet</span>
                    </a>
                </li>
                <li class="py-4 pl-10 sidebar-button" id="logout-btn">
                    <a href="logout.php" class="text-white text-lg flex items-center">
                        <i class="fas fa-sign-out-alt"></i> <!-- Logout icon -->
                        <span class="ml-4">Logout</span>
                    </a>
                </li>
                <!-- Add more menu items as needed -->
            </ul>
        </nav>
    </div>

    <!-- Content Area -->
    <div class="content p-4" id="content">
        <!-- Default content or message can be shown here initially -->
        <?php
        echo "Welcome to your dashboard!";
        ?>
    </div>
    <script src="./sidebar.js"></script>
    <script>
        $(document).ready(function() {
            // When profile button is clicked
            $('#profile-btn').click(function() {
                loadContent('profile.php');
            });
            // When profile button is clicked
            $('#add-product-btn').click(function() {
                loadContent('add_product.php');
            });
            // When profile button is clicked
            $('#wallet-btn').click(function() {
                loadContent('Seller_wallet.php');
            });
            // When home button is clicked
            $('#logout-btn').click(function() {
                loadContent('logout.php');
            });

            // Function to load content via AJAX
            function loadContent(page) {
                $.ajax({
                    url: page, // The page to load (e.g., profile.php)
                    type: 'GET',
                    success: function(response) {
                        $('#content').html(response); // Replace the content in #content div with the response
                    },
                    error: function() {
                        $('#content').html('<p>Error loading content.</p>');
                    }
                });
            }
        });
    </script>

</body>

</html>