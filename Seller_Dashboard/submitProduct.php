<?php
// Start the session to access session data
session_start();

// Database connection
include "../Database_Connection/DB_Connection.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$product_added = false; // Set a default variable for success

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch form data
    $product_name = trim($_POST['product_name']);
    $product_description = trim($_POST['product_description']);
    $product_condition = trim($_POST['product_condition']);
    $product_price = trim($_POST['product_price']);
    $product_category = trim($_POST['product_category']);

    // Get seller_id from session (assuming user is logged in)
    $seller_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

    // Initialize variables
    $image_path = "";
    $upload_error = "";
    $target_dir = "../Second_hand/S_products";

    // Ensure uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // File upload handling
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        // Validate file type
        if (!in_array($_FILES['product_image']['type'], $allowed_types)) {
            $upload_error = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        }
        // Validate file size
        elseif ($_FILES['product_image']['size'] > $max_size) {
            $upload_error = "File size exceeds the 2MB limit.";
        } else {
            // Generate unique file name
            $unique_name = uniqid() . "_" . basename($_FILES["product_image"]["name"]);
            $image_path = $target_dir . '/' . $unique_name;

            if (!move_uploaded_file($_FILES["product_image"]["tmp_name"], $image_path)) {
                $upload_error = "Failed to move uploaded file.";
            }
        }
    } else {
        $upload_error = "File upload error: " . $_FILES['product_image']['error'];
    }

    if ($upload_error) {
        $error_message = $upload_error;
    } else {
        // Insert into database using prepared statements
        $stmt = $conn->prepare(
            "INSERT INTO second_hand_product 
            (Sh_product_name, Sh_category, Sh_Product_description, Sh_Product_present_condition, Sh_price, Sh_image_path, Sh_date_posted, seller_id) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)"
        );

    

        // Bind the parameters
        $stmt->bind_param(
            "ssssdsi",
            $product_name,
            $product_category,
            $product_description,
            $product_condition,
            $product_price,
            $image_path,
            $seller_id
        );

        // Execute the statement
        if ($stmt->execute()) {
            // Set flag to true if product is added
            $product_added = true;
            // Redirect to seller dashboard with a success alert
            echo "<script>
                    alert('Product added successfully!');
                    window.location.href = 'Seller_dashboard.php';
                  </script>";
            exit; // Make sure to stop further execution
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
