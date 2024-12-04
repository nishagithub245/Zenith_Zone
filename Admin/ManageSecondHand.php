<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Pending Approval</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #1f2937;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100">
    <div class="flex pt-40">
        <div class="ml-64 container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Pending Approval Products</h1>

            <?php
            include "../Database_Connection/DB_Connection.php";

            $query = "SELECT * FROM second_hand_product WHERE approval_status = 'pending'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0): ?>
                <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gray-200 text-left text-gray-600">
                            <th class="py-3 px-4">#</th>
                            <th class="py-3 px-4">Product Name</th>
                            <th class="py-3 px-4">Category</th>
                            <th class="py-3 px-4">Price (BDT)</th>
                            <th class="py-3 px-4">Date Posted</th>
                            <th class="py-3 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <tr class="border-t">
                                <td class="py-3 px-4"><?php echo $count++; ?></td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($row['Sh_product_name']); ?></td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($row['Sh_category']); ?></td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($row['Sh_price']); ?></td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($row['Sh_date_posted']); ?></td>
                                <td class="py-3 px-4">
                                    <button 
                                        class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 view-btn"
                                        data-id="<?php echo $row['Sh_product_id']; ?>"
                                    >
                                        View
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-gray-500 text-center mt-6">No products found for approval.</p>
            <?php endif; ?>

            <?php $conn->close(); ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Handle click event on "View" button
            $('.view-btn').click(function () {
                var productId = $(this).data('id'); // Get product ID from the button data

                // Send an AJAX request to redirect to the product details page
                $.ajax({
                    url: 'SecondHandDetails.php',  // URL of the product details page
                    type: 'GET',
                    data: { id: productId },  // Send the product ID
                    success: function(response) {
                        // On success, perform the redirect
                        $('#content').html(response); 
                    },
                    error: function() {
                        alert('Failed to fetch product details.');
                    }
                });
            });
        });
    </script>
</body>
</html>
