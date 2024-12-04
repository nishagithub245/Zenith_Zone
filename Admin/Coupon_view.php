<?php
// Start the session
session_start();

// Include your database connection
include "../Database_Connection/DB_Connection.php";

$query = "SELECT * FROM Coupon";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching coupons: " . $conn->error);
}

$current_time = date("Y-m-d H:i:s"); // Get current time
$update_query = "UPDATE Coupon SET status = 'Inactive' WHERE end_date < '$current_time' AND status = 'Active'";
$conn->query($update_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupons</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .timer {
            font-weight: bold;
            color: green;
        }

        .inactive {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto my-10 px-4">
        <h1 class="text-xl font-bold text-center mb-6">Coupons List</h1>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-left">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Serial</th>
                        <th class="px-4 py-2">Coupon Code</th>
                        <th class="px-4 py-2">Coupon Name</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Discount Rate</th>
                        <!-- Commented Start Date and End Date Columns -->
                        <!-- <th class="px-4 py-2">Start Date</th> -->
                        <!-- <th class="px-4 py-2">End Date</th> -->
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Time Remaining</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    while ($coupon = $result->fetch_assoc()) {
                        $coupon_id = $coupon['coupon_id'];
                        $coupon_code = $coupon['coupon_code'];
                        $coupon_name = $coupon['coupon_name'];
                        $coupon_description = $coupon['coupon_description'];
                        $discount_rate = $coupon['discount_rate'];
                        $start_date = $coupon['start_date'];
                        $end_date = $coupon['end_date'];
                        $status = $coupon['status'];
                    ?>
                        <tr>
                            <td class="border px-4 py-2"><?= $counter++; ?></td>
                            <td class="border px-4 py-2"><?= $coupon_code ?></td>
                            <td class="border px-4 py-2"><?= $coupon_name ?></td>
                            <td class="border px-4 py-2"><?= $coupon_description ?></td>
                            <td class="border px-4 py-2"><?= $discount_rate ?>%</td>
                            <!-- Commented Start Date and End Date Columns -->
                            <!-- <td class="border px-4 py-2"><?= $start_date ?></td> -->
                            <!-- <td class="border px-4 py-2"><?= $end_date ?></td> -->
                            <td class="border px-4 py-2 <?= $status == 'Inactive' ? 'text-red-500' : 'text-green-500' ?>"><?= $status ?></td>
                            <td class="border px-4 py-2">
                                <span class="timer" id="timer-<?= $coupon_id ?>"></span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function updateTimer(coupon_id, end_date) {
            const endTime = new Date(end_date).getTime();
            const timerElement = document.getElementById("timer-" + coupon_id);

            const interval = setInterval(function () {
                const currentTime = new Date().getTime();
                const timeRemaining = endTime - currentTime;

                if (timeRemaining <= 0) {
                    clearInterval(interval);
                    timerElement.innerHTML = "Expired";
                    updateCouponStatusToInactive(coupon_id); // Call AJAX function to update status to 'Inactive'
                } else {
                    // Calculate days, hours, minutes, seconds
                    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
                    timerElement.innerHTML = `${days} Days, ${hours} Hours, ${minutes} Minutes, ${seconds} Seconds`;
                }
            }, 1000); // Update every second
        }

        // Function to update coupon status to 'Inactive' via AJAX
        function updateCouponStatusToInactive(coupon_id) {
            $.ajax({
                url: 'update_coupon_status.php',
                type: 'POST',
                data: { coupon_id: coupon_id },
                success: function (response) {
                    console.log('Status updated to Inactive for coupon ID ' + coupon_id);
                },
                error: function () {
                    console.log('Error updating coupon status');
                }
            });
        }

        // Initialize all timers
        <?php
        // Output JavaScript to initialize timers for each coupon
        $result->data_seek(0); // Reset result pointer
        while ($coupon = $result->fetch_assoc()) {
            echo "updateTimer(" . $coupon['coupon_id'] . ", '" . $coupon['end_date'] . "');\n";
        }
        ?>
    </script>
</body>

</html>
