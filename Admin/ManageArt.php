<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Gallery - Pending Approval</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .hidden {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100">
    <div class="flex pt-40">
        <div class="ml-64 container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Pending Approval - Art Gallery</h1>

            <?php
            include "../Database_Connection/DB_Connection.php";

            $query = "SELECT * FROM art_gallery WHERE approval_status = 'pending'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0): ?>
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-200 text-left text-gray-600">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">Art Name</th>
                        <th class="py-3 px-4">Artist ID</th>
                        <th class="py-3 px-4">Initial Price</th>
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
                        <td class="py-3 px-4"><?php echo htmlspecialchars($row['art_name']); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($row['artist_id']); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($row['art_init_price']); ?> BDT</td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($row['creation_date']); ?></td>
                        <td class="py-3 px-4">
                            <button class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 view-btn"
                                data-id="<?php echo $row['art_id']; ?>">View</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="text-gray-500 text-center mt-6">No art found for approval.</p>
            <?php endif; ?>

            <?php $conn->close(); ?>

            <!-- Art details section -->
            <div id="art-details" class="mt-6 hidden">
                <h2 class="text-xl font-semibold">Art Details</h2>
                <div id="art-info" class="mt-4">
                    <!-- Art details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        $(document).ready(function () {
            let artId;

            // Show art details when "View" button is clicked
            $('.view-btn').click(function () {
                artId = $(this).data('id');
                $('#art-details').removeClass('hidden'); // Show art details section
                $('#art-info').html('Loading art details...'); // Show loading message

                // Fetch art details using AJAX
                $.ajax({
                    url: './Art_details.php',
                    type: 'GET',
                    data: { id: artId },
                    success: function (data) {
                        $('#art-info').html(data); // Populate art details
                    },
                    error: function () {
                        $('#art-info').html('<p class="text-red-500">Failed to fetch art details. Please try again later.</p>');
                    }
                });
            });
        });
    </script>
</body>

</html>
