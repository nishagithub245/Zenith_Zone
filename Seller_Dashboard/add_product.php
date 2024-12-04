<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function closeModalAndRedirect(redirectUrl) {
            setTimeout(function() {
                const modal = document.querySelector('dialog[open]');
                if (modal) modal.close();
                window.location.href = redirectUrl;
            }, 3000);
        }
    </script>
</head>

<body class="min-h-screen">

    <div class="flex">
        <!-- Include Sidebar -->
        <div class="container mx-auto flex justify-center items-center px-2 mt-48">
            <div class="bg-white p-2 rounded-xl shadow-xl ">
                <!-- Add Product Form -->
                <form method="POST" action="submitProduct.php" enctype="multipart/form-data" class="space-y-6">
                    <h1 class="text-4xl font-bold text-center">Add a Second Hand Product</h1>
                    <!-- Product Name -->
                    <div>
                        <label for="product_name" class="block text-gray-600 font-semibold mb-2">Product Name</label>
                        <input type="text" id="product_name" name="product_name" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter product name" required>
                    </div>

                    <!-- Product Description -->
                    <div>
                        <label for="product_description" class="block text-gray-600 font-semibold mb-2">Description</label>
                        <textarea id="product_description" name="product_description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter product description" required></textarea>
                    </div>

                    <!-- Product Condition -->
                    <div>
                        <label for="product_condition" class="block text-gray-600 font-semibold mb-2">Condition</label>
                        <textarea id="product_condition" name="product_condition" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Describe the condition of the product" required></textarea>
                    </div>


                    <!-- Product Image -->
                    <div>
                        <label for="product_image" class="block text-gray-600 font-semibold mb-2">Upload Image</label>
                        <input type="file" id="product_image" name="product_image" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>

                    <!-- Product Price -->
                    <div>
                        <label for="product_price" class="block text-gray-600 font-semibold mb-2">Price (in BDT)</label>
                        <input type="number" id="product_price" name="product_price" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter product price" required>
                    </div>

                    <!-- Product Category -->
                    <div>
                        <label for="product_category" class="block text-gray-600 font-semibold mb-2">Category</label>
                        <select id="product_category" name="product_category" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Select Category</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Clothing">Clothing</option>
                            <option value="Books">Books</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-300">
                        Add Product
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <?php if (isset($product_added) && $product_added): ?>
        <dialog id="successModal" open class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-5 shadow text-center">
                <h3 class="text-lg font-bold mt-4">Product Added Successfully!</h3>
                <p class="mt-2 text-green-700">The product has been added successfully.</p>
                <div class="flex justify-center mt-4">
                    <button onclick="closeModalAndRedirect('add_product.php');" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Close</button>
                </div>
            </div>
        </dialog>
        <script>
            closeModalAndRedirect('add_product.php');
        </script>
    <?php elseif (isset($error_message)): ?>
        <!-- Error Modal -->
        <dialog id="errorModal" open class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-5 shadow text-center">
                <h3 class="text-lg font-bold text-red-700 mt-4">Error Adding Product</h3>
                <p class="mt-2"><?php echo $error_message; ?></p>
                <div class="flex justify-center mt-4">
                    <button onclick="closeModalAndRedirect('add_product.php');" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Close</button>
                </div>
            </div>
        </dialog>
        <script>
            closeModalAndRedirect('add_product.php');
        </script>
    <?php endif; ?>
</body>

</html>
