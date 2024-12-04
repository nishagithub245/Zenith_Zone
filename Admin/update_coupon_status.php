<?php
// Include the database connection
include "../Database_Connection/DB_Connection.php";

// Get the coupon_id and status from the POST request
$coupon_id = $_POST['coupon_id'];
$status = $_POST['status'];

// Update the coupon status in the database
$query = "UPDATE Coupon SET status = ? WHERE coupon_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $status, $coupon_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // echo "Status updated successfully.";
} else {
    echo "Failed to update status.";
}
?>
