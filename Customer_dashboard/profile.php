<?php
session_start();

// Get user_id from the URL query parameter
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


if ($userId) {
    // You can now fetch and display the user's profile based on this user_id
    // For example, fetching data from the database
    include "../Database_Connection/DB_Connection.php";

    $query = "SELECT * FROM customer_info WHERE customer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $customer = $result->fetch_assoc();
    if (!$customer) {
        echo "Customer not found!";
        exit;
    }
} else {
    echo "No user ID provided!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is loaded -->
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-4xl bg-white p-8 rounded-lg shadow-lg">
        <!-- Profile Picture Section -->
        <div class="flex justify-center mb-8">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-500 shadow-lg">
                <img src="<?= htmlspecialchars($customer['customer_picture'] ?? '/path/to/default-avatar.png') ?>"
                    alt="Profile Picture" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Customer Information Form -->
        <form id="customerForm">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-8"><?= htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']) ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="firstName" class="text-gray-700 text-sm font-semibold">First Name</label>
                    <input id="firstName" name="firstName" type="text" value="<?= htmlspecialchars($customer['first_name']) ?>"
                        class="w-full bg-gray-50 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" readonly />
                </div>
                <div>
                    <label for="lastName" class="text-gray-700 text-sm font-semibold">Last Name</label>
                    <input id="lastName" name="lastName" type="text" value="<?= htmlspecialchars($customer['last_name']) ?>"
                        class="w-full bg-gray-50 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" readonly />
                </div>
            </div>

            <div class="mt-6">
                <label for="address" class="text-gray-700 text-sm font-semibold">Address</label>
                <input id="address" name="address" type="text" value="<?= htmlspecialchars($customer['address']) ?>"
                    class="w-full bg-gray-50 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" readonly />
            </div>

            <div class="mt-6">
                <label for="mobileNumber" class="text-gray-700 text-sm font-semibold">Mobile Number</label>
                <input id="mobileNumber" name="mobileNumber" type="tel" value="<?= htmlspecialchars($customer['mobile_number']) ?>"
                    class="w-full bg-gray-50 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" readonly />
            </div>

            <div class="mt-6">
                <label for="email" class="text-gray-700 text-sm font-semibold">Email</label>
                <input id="email" name="email" type="email" value="<?= htmlspecialchars($customer['email']) ?>"
                    class="w-full bg-gray-50 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" readonly />
            </div>

            <div class="mt-6">
                <label for="dob" class="text-gray-700 text-sm font-semibold">Date of Birth</label>
                <input id="dob" name="dob" type="date" value="<?= htmlspecialchars($customer['date_of_birth']) ?>"
                    class="w-full bg-gray-50 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" readonly />
            </div>

            <!-- Gender Field -->
            <div class="mt-6">
                <label for="gender" class="text-gray-700 text-sm font-semibold">Gender</label>
                <input id="gender" name="gender" type="text" value="<?= htmlspecialchars($customer['gender']) ?>"
                    class="w-full bg-gray-50 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" readonly />
            </div>

            <!-- NID Field -->
            <div class="mt-6">
                <label for="nid" class="text-gray-700 text-sm font-semibold">NID Number</label>
                <input id="nid" name="nid" type="text" value="<?= htmlspecialchars($customer['nid_number']) ?>"
                    class="w-full bg-gray-50 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" readonly />
            </div>
            <!-- Edit Profile Button -->
            <div class="mt-8 text-center">
                <button type="button" id="editProfileButton" class="bg-blue-500 text-white py-2 px-6 rounded">Edit Profile</button>
            </div>

        </form>
    </div>

     <!-- jQuery AJAX to load the edit profile form -->
     <script>
        $(document).ready(function() {
            $('#editProfileButton').click(function() {
                $.ajax({
                    url: 'edit_profile.php',  // The file that contains the edit form
                    type: 'GET',
                    success: function(response) {
                        $('#content').html(response);  // Assuming there is a div with id 'content' in your dashboard to display content
                    },
                    error: function() {
                        alert('Error loading the edit profile form');
                    }
                });
            });
        });
    </script>
</body>

</html>