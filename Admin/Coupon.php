<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Coupon</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script> <!-- Add Font Awesome CDN -->
</head>

<body class="font-poppins bg-gray-50">

    <!-- Modal Structure for Success/Errors -->
    <div id="messageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-5 shadow text-center">
            <i id="modalIcon" class="fas fa-check-circle fa-5x text-green-500"></i>

            <h3 id="modalTitle" class="text-lg font-bold mt-4">Title Here</h3>
            <p id="modalMessage" class="mt-2">Message Here</p>
            <button onclick="hideModal()" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Close</button>
        </div>
    </div>

    <div class="flex items-center justify-center min-h-screen py-6 bg-gray-100">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Generate New Coupon</h2>

            <form id="couponForm" method="POST" class="space-y-6">

                <!-- Coupon Code -->
                <div>
                    <label for="coupon_code" class="block text-lg font-medium text-gray-700">Coupon Code</label>
                    <input id="coupon_code" name="coupon_code" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700" placeholder="Enter coupon code (e.g., SAVE20)" />
                </div>

                <!-- Coupon Name -->
                <div>
                    <label for="coupon_name" class="block text-lg font-medium text-gray-700">Coupon Name</label>
                    <input id="coupon_name" name="coupon_name" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700" placeholder="Enter coupon name" />
                </div>

                <!-- Coupon Description -->
                <div>
                    <label for="coupon_description" class="block text-lg font-medium text-gray-700">Coupon Description</label>
                    <textarea id="coupon_description" name="coupon_description" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 h-32" placeholder="Enter coupon description"></textarea>
                </div>

                <!-- Discount Rate -->
                <div>
                    <label for="discount_rate" class="block text-lg font-medium text-gray-700">Discount Rate (1-100%)</label>
                    <input id="discount_rate" name="discount_rate" type="number" min="1" max="100" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700" placeholder="Enter discount rate" />
                </div>

                <!-- Minimum Price -->
                <div>
                    <label for="minimum_price" class="block text-lg font-medium text-gray-700">Minimum Price</label>
                    <input id="minimum_price" name="minimum_price" type="number" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700" placeholder="Enter minimum price" />
                </div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-lg font-medium text-gray-700">Start Date</label>
                    <input id="start_date" name="start_date" type="datetime-local" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700" />
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-lg font-medium text-gray-700">End Date</label>
                    <input id="end_date" name="end_date" type="datetime-local" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700" />
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="w-full py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Generate Coupon</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.getElementById('couponForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            var formData = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'GenerateCoupon.php', true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    // Show modal based on the response status
                    if (response.status === 'success') {
                        showModal('Success', response.message, 'text-green-500', 'fa-check-circle');
                    } else {
                        showModal('Error', response.message, 'text-red-500', 'fa-exclamation-circle');
                    }

                    // Clear the form after submission
                    document.getElementById('couponForm').reset(); // Reset the form fields
                }
            };

            xhr.send(formData); // Send form data via AJAX
        });

        function showModal(title, message, iconClass, icon) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('modalIcon').className = `fas ${icon} fa-5x ${iconClass}`; // Update the icon class dynamically
            document.getElementById('messageModal').classList.remove('hidden'); // Show the modal
        }

        // For success, pass 'text-green-500' and 'fa-check-circle' icon
        function showSuccessModal() {
            showModal('Success', 'Coupon created successfully!', 'text-green-500', 'fa-check-circle');
        }

        // For error, pass 'text-red-500' and 'fa-exclamation-circle' icon
        function showErrorModal() {
            showModal('Error', 'There was an issue with the coupon creation!', 'text-red-500', 'fa-exclamation-circle');
        }

        function hideModal() {
            document.getElementById('messageModal').classList.add('hidden'); // Hide the modal
        }
    </script>

</body>

</html>