<?php
include "../Database_Connection/DB_Connection.php"; // Assuming this file connects to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $coupon_code = $_POST['coupon_code'];
    $order_total = $_POST['order_total']; 
    
    // Validate the coupon code from the database
    $sql = "SELECT * FROM coupon WHERE coupon_code = ? AND status = 'Active' AND start_date <= NOW() AND end_date >= NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $coupon_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Coupon is valid, get the details
        $coupon = $result->fetch_assoc();
        
        // Check if the order total meets the minimum price requirement for the coupon
        if ($order_total >= $coupon['minimum_price']) {
            // Return the discount rate to the frontend
            echo json_encode([
                'success' => true,
                'discountRate' => $coupon['discount_rate'] // Send the discount rate
            ]);
        } else {
            // Order total is less than the minimum price required for the coupon
            echo json_encode([
                'success' => false,
                'message' => 'Order total is less than the minimum price required for this coupon.'
            ]);
        }
    } else {
        // Invalid or expired coupon
        echo json_encode([
            'success' => false,
            'message' => 'Invalid or expired coupon code.'
        ]);
    }
} else {
    // Coupon code not provided
    echo json_encode([
        'success' => false,
        'message' => 'Coupon code not provided.'
    ]);
}
?>
