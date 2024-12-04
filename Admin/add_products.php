<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100 font-poppins">
    <div class="max-w-4xl mx-auto p-8">
        <h1 class="text-center text-2xl font-semibold text-gray-800 mb-8">Add New Product</h1>

        <form id="addProductForm" action="add_product.php" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">

            <!-- Product Name -->
            <div class="mb-6">
                <label for="productName" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input id="productName" name="product_name" type="text" required class="w-full mt-2 p-3 bg-gray-100 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Enter product name" />
            </div>

            <!-- Product Category (Auto-suggest) -->
            <div class="mb-6">
                <label for="productCategory" class="block text-sm font-medium text-gray-700">Product Category</label>
                <input id="productCategory" name="product_category" type="text" required class="w-full mt-2 p-3 bg-gray-100 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Start typing to search categories..." onkeyup="showCategorySuggestions(this.value)" />
                <div id="categorySuggestions" class="absolute bg-white border border-gray-300 w-full mt-1 max-h-48 overflow-auto z-10 hidden"></div>
            </div>

            <!-- Product Description -->
            <div class="mb-6">
                <label for="productDescription" class="block text-sm font-medium text-gray-700">Product Description</label>
                <textarea id="productDescription" name="product_description" required class="w-full mt-2 p-3 bg-gray-100 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Enter product description"></textarea>
            </div>

            <!-- Product Image Upload -->
            <div class="mb-6">
                <label for="productImage" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input id="productImage" name="product_image" type="file" accept="image/*" required class="w-full mt-2 p-3 bg-gray-100 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" />
            </div>

            <!-- Old Price -->
            <div class="mb-6">
                <label for="oldPrice" class="block text-sm font-medium text-gray-700">Old Price</label>
                <input id="oldPrice" name="old_price" type="number" min="0" step="0.01" required class="w-full mt-2 p-3 bg-gray-100 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Enter old price" />
            </div>

            <!-- New Price -->
            <div class="mb-6">
                <label for="newPrice" class="block text-sm font-medium text-gray-700">New Price</label>
                <input id="newPrice" name="new_price" type="number" min="0" step="0.01" required class="w-full mt-2 p-3 bg-gray-100 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Enter new price" />
            </div>

            <!-- Stock Quantity -->
            <div class="mb-6">
                <label for="stockQuantity" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                <input id="stockQuantity" name="stock_quantity" type="number" min="1" required class="w-full mt-2 p-3 bg-gray-100 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Enter stock quantity" />
            </div>

            <!-- Submit Button -->
            <div class="mb-6">
                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Product</button>
            </div>
        </form>
    </div>
    <!-- Modal Structure for Errors and Success -->
    <div id="messageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-5 shadow text-center">
            <i id="modalIcon" class="fas fa-exclamation-circle fa-5x text-red-500"></i>
            <h3 id="modalTitle" class="text-lg font-bold mt-4">Title Here</h3>
            <p id="modalMessage" class="mt-2">Message Here</p>
            <button onclick="hideModal()" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Close</button>
        </div>
    </div>


    <script>
        function showCategorySuggestions(query) {
            if (query.length === 0) {
                document.getElementById('categorySuggestions').style.display = "none";
                return;
            }

            // AJAX request to fetch category suggestions
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_category_suggestions.php?query=" + query, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var suggestions = JSON.parse(xhr.responseText);
                    var suggestionList = document.getElementById('categorySuggestions');
                    suggestionList.innerHTML = ""; // Clear previous suggestions
                    suggestions.forEach(function(category) {
                        var div = document.createElement("div");
                        div.classList.add("p-2", "cursor-pointer", "hover:bg-gray-200");
                        div.textContent = category;
                        div.onclick = function() {
                            document.getElementById('productCategory').value = category;
                            suggestionList.style.display = "none";
                        };
                        suggestionList.appendChild(div);
                    });
                    suggestionList.style.display = "block"; // Show suggestions
                }
            };
            xhr.send();
        }

        document.getElementById('addProductForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting normally

            // Create FormData object for AJAX submission
            var formData = new FormData(this);

            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_product.php', true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    console.log(response); // Check the response in the console

                    if (response.status === 'success') {
                        // Show success modal
                        showModal('Success', 'Product added successfully!', 'fa-check-circle', 'text-green-500');
                        // Optionally, close the form or reset it
                        document.getElementById('addProductForm').reset();
                    } else {
                        // Show error modal with the error message
                        showModal('Error', response.message || 'An error occurred. Please try again.', 'fa-exclamation-circle', 'text-red-500');
                    }
                }
            };

            xhr.send(formData); // Send the FormData object to the server
        });

        // Function to show the modal with dynamic content
        function showModal(title, message, iconClass, iconColorClass) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalMessage').innerText = message;
            document.getElementById('modalIcon').classList.remove('text-red-500', 'text-green-500'); // Remove previous icon colors
            document.getElementById('modalIcon').classList.add(iconColorClass); // Add the new color class
            document.getElementById('modalIcon').classList.add(iconClass); // Change icon class
            document.getElementById('messageModal').style.display = 'flex'; // Show the modal
        }

        // Function to hide the modal
        function hideModal() {
            document.getElementById('messageModal').style.display = 'none';
        }
    </script>

</body>

</html>