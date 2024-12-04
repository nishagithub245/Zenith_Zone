<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>ZenithZone Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <div class="bg-blue-900 text-white w-full md:w-64 lg:w-64 p-4">
            <div class="mb-8">
                <img src="./image/logo.png" alt="ZenithZone Logo" class="h-16 mx-auto">
            </div>
            <button onclick="showSection('dashboard')" class="w-full text-left p-4 mb-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105 flex items-center">
    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
</button>
<button onclick="showSection('add_products')" class="w-full text-left p-4 mb-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105 flex items-center">
    <i class="fas fa-plus-circle mr-3"></i> Add Products
</button>
<button onclick="showSection('modify_product')" class="w-full text-left p-4 mb-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105 flex items-center">
    <i class="fas fa-cogs mr-3"></i> Product Status
</button>
<button onclick="showSection('coupon_code')" class="w-full text-left p-4 mb-4 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105 flex items-center">
    <i class="fas fa-tags mr-3"></i> Coupon Code
</button>


            <!-- Add more buttons for other sections if needed -->
        </div>

        <!-- Content Area -->
        <div id="content" class="w-full md:w-3/4 lg:w-4/5 p-8">
            <!-- Content will be loaded here dynamically -->
        </div>
    </div>

    <script src="admin.js"></script>
</body>

</html>