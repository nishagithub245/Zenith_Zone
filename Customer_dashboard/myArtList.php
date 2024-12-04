<?php
session_start();
// Include the database connection file
include "../Database_Connection/DB_Connection.php";

$artList = [];
$errorMsg = ''; // Variable to hold error messages

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if ($userId) { // Check if the user is logged in

    // Query to fetch art items where the logged-in user is the winner
    $artQuery = "SELECT art_id, art_name, art_img, final_bid_price FROM art_gallery WHERE winner_customer_id = ?";
    if ($stmt = $conn->prepare($artQuery)) {
        $stmt->bind_param("i", $userId);  // Bind the user ID to the query
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Fetch all art items for this user
            while ($art = $result->fetch_assoc()) {
                $artList[] = $art;  // Store each art item in the list
            }
        } else {
            $errorMsg = "No art found for this user.";
        }
        $stmt->close();
    } else {
        echo "Error preparing art query: " . $conn->error;
    }
} else {
    $errorMsg = "User ID not provided.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Art List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .art-container {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Art List -->
            <div class="flex-1 bg-white rounded-xl shadow-lg p-4">
                <h2 class="text-2xl font-bold mb-6 text-center">Your Art List</h2>

                <?php
                if (!empty($artList)) {
                    echo '<div class="art-container">';
                    foreach ($artList as $art) {
                        echo "<div class='mt-4 flex items-center justify-between py-4 border-b'>";
                        echo "<div class='flex items-center space-x-6'>";

                        // Display the art image
                        echo "<img src='../Art/{$art['art_img']}' alt='{$art['art_name']}' class='w-32 h-32 object-cover rounded-md shadow-sm'/>";

                        // Display the art details (name, final bid price)
                        echo "<div class='flex flex-col'>";
                        echo "<span class='text-lg font-medium text-gray-900'>{$art['art_name']}</span>";
                        echo "<span class='text-lg text-orange-500'>৳" . number_format($art['final_bid_price'], 2) . "</span>";
                        echo "</div>";  // Close flex-column

                        echo "</div>";  // Close flex-items-center

                        // "View" button
                        echo "<div class='flex justify-center items-center'>";
                        echo "<button class='btn btn-sm btn-info view-art-details' data-art-id='{$art['art_id']}'>View Details</button>";
                        echo "</div>";

                        echo "</div>";  // Close mt-4
                    }
                    echo '</div>';  // Close art-container
                } else {
                    echo "<p>$errorMsg</p>";
                }
                ?>
            </div>

        </div>
    </div>

    <!-- Add an area to display art details -->
    <div id="artDetails" class="mt-8 p-4 bg-white rounded-xl shadow-lg">
        <!-- Art details will be loaded here by AJAX -->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // AJAX for "View Details" button
        $(document).ready(function() {
            $('.view-art-details').click(function() {
                var artId = $(this).data('art-id'); // Get the art ID

                // Check if the artId is being correctly retrieved
                console.log('Art ID:', artId);

                $.ajax({
                    url: 'Art_details.php', // The file that contains the art details
                    type: 'GET',
                    data: {
                        art_id: artId
                    },
                    success: function(response) {
                        console.log('Response:', response); // Check the response data
                        // Insert the response (the art details) into the artDetails div
                        $('#artDetails').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', status, error); // Log AJAX error if any
                        alert('Error loading art details');
                    }
                });
            });
        });
    </script>
</body>

</html>