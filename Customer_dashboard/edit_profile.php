<?php
session_start();
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$userId) {
    echo "User not logged in.";
    exit;
}

include "../Database_Connection/DB_Connection.php";

// Retrieve customer data from the database
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="flex flex-grow justify-center">
        <!-- Main content area -->
        <div class="w-full p-6 bg-white rounded-lg shadow-lg">
            <form id="editProfileForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Edit Profile</h2>

                <!-- Profile Picture -->
                <div class="flex justify-center">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-blue-500">
                        <img id="profilePreview" src="<?= htmlspecialchars($customer['customer_picture'] ?? 'https://via.placeholder.com/150') ?>" 
                             alt="Profile Picture" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="text-center">
                    <label for="profilePicture" class="block mb-2 text-sm text-gray-600">Upload New Profile Picture</label>
                    <input id="profilePicture" name="profilePicture" type="file" accept="image/*" 
                           class="text-sm text-gray-800 border border-gray-300 rounded-lg px-3 py-2"
                           onchange="previewImage(event)">
                </div>

                <!-- First and Last Name -->
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label class="text-gray-800 text-xs block mb-2">First Name</label>
                        <input id="firstName" name="firstName" type="text" value="<?= htmlspecialchars($customer['first_name']) ?>" 
                               class="w-full bg-gray-50 text-sm border border-gray-300 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex-1">
                        <label class="text-gray-800 text-xs block mb-2">Last Name</label>
                        <input id="lastName" name="lastName" type="text" value="<?= htmlspecialchars($customer['last_name']) ?>" 
                               class="w-full bg-gray-50 text-sm border border-gray-300 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label class="text-gray-800 text-xs block mb-2">Address</label>
                    <input id="address" name="address" type="text" value="<?= htmlspecialchars($customer['address']) ?>" 
                           class="w-full bg-gray-50 text-sm border border-gray-300 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="text-gray-800 text-xs block mb-2">Date of Birth</label>
                    <input id="dob" name="dob" type="date" value="<?= htmlspecialchars($customer['date_of_birth']) ?>" 
                           class="w-full bg-gray-50 text-sm border border-gray-300 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- National ID (NID) -->
                <div>
                    <label class="text-gray-800 text-xs block mb-2">National ID (NID)</label>
                    <input id="nid" name="nid" type="text" value="<?= htmlspecialchars($customer['nid_number']) ?>" 
                           class="w-full bg-gray-50 text-sm border border-gray-300 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-500 text-white hover:bg-blue-700 px-6 py-2 rounded-lg">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to preview image
        function previewImage(event) {
            const preview = document.getElementById('profilePreview');
            const file = event.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        }

        // Form submission via AJAX
        document.getElementById('editProfileForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent normal form submission

            const formData = new FormData(this);
            
            // Send the data to the server using AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_profile.php', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Profile updated successfully!');
                    location.reload();
                    // Redirect to the referring page after success
                } else {
                    alert('Error updating profile.');
                }
            };

            xhr.send(formData);
        });
    </script>
</body>

</html>
