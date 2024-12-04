<?php
session_start();
include "../Database_Connection/DB_Connection.php";

// Ensure the user is logged in
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if (!$userId) {
    echo "User not logged in.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $customer_picture = ''; // Default to no picture if not uploaded

    // Handle file upload if a new profile picture is provided
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../uploads/customers/";
        $fileName = uniqid("customer_", true) . "." . pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
        $filePath = $uploadDir . $fileName;
        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $allowedTypes = ['image/jpeg', 'image/png'];
        if ($_FILES['profilePicture']['size'] > 2 * 1024 * 1024) {
            echo "File size exceeds limit.";
            exit;
        }
        
        if (!in_array($_FILES['profilePicture']['type'], $allowedTypes)) {
            echo "Invalid file type.";
            exit;
        }

        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $filePath)) {
            $customer_picture = $filePath;
        } else {
            echo "Error uploading file.";
            exit;
        }
    }

    // Update the profile in the database
    $query = "UPDATE customer_info 
              SET first_name = ?, last_name = ?, address = ?, date_of_birth = ?, customer_picture = ? 
              WHERE customer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $first_name, $last_name, $address, $dob, $customer_picture, $userId);

    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile.";
    }
}
?>
