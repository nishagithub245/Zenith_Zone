<?php
// Include the database connection file
include "../Database_Connection/DB_Connection.php"; // Make sure this file contains the $conn variable

$response = ['status' => 'error', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $coupon_code = mysqli_real_escape_string($conn, $_POST['coupon_code']);
    $coupon_name = mysqli_real_escape_string($conn, $_POST['coupon_name']);
    $coupon_description = mysqli_real_escape_string($conn, $_POST['coupon_description']);
    $discount_rate = mysqli_real_escape_string($conn, $_POST['discount_rate']);
    $minimum_price = mysqli_real_escape_string($conn, $_POST['minimum_price']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

    // Determine the status based on the current date and the end date
    $current_time = date('Y-m-d H:i:s'); // Get current timestamp
    if ($current_time > $end_date) {
        $status = 'Inactive'; // Set to inactive if current time is greater than the end date
    } else {
        $status = 'Active'; // Otherwise, set to active
    }

    // Insert the coupon data into the database
    $query = "INSERT INTO Coupon (coupon_code, coupon_name, coupon_description, discount_rate, minimum_price, start_date, end_date, status) 
              VALUES ('$coupon_code', '$coupon_name', '$coupon_description', '$discount_rate', '$minimum_price', '$start_date', '$end_date', '$status')";

    if (mysqli_query($conn, $query)) {
        $response = ['status' => 'success', 'message' => 'Coupon created successfully!'];
    } else {
        $response = ['status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)];
    }

    // Close the connection
    mysqli_close($conn);

    // Return the response in JSON format
    echo json_encode($response);
}
?>
