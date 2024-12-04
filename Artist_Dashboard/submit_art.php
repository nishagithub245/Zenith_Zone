<?php
session_start();
// Database connection
include "../Database_Connection/DB_Connection.php"; // Ensure the file path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch form data
    $art_name = trim($_POST['art_name']);
    $art_description = trim($_POST['art_description']);
    $art_init_price = trim($_POST['art_init_price']);
    
    // Get artist_id from session (assuming user is logged in)
    $artist_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

    // Initialize variables
    $image_path = "";
    $error_message = "";
    $upload_error = "";
    $target_dir = "../art_gallery";

    // Ensure uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // File upload handling
    if (isset($_FILES['art_img']) && $_FILES['art_img']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 6 * 1024 * 1024; // 2MB

        // Validate file type
        if (!in_array($_FILES['art_img']['type'], $allowed_types)) {
            $upload_error = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        }
        // Validate file size
        elseif ($_FILES['art_img']['size'] > $max_size) {
            $upload_error = "File size exceeds the 2MB limit.";
        } else {
            // Generate unique file name
            $unique_name = uniqid() . "_" . basename($_FILES["art_img"]["name"]);
            $image_path = $target_dir . $unique_name;

            if (!move_uploaded_file($_FILES["art_img"]["tmp_name"], $image_path)) {
                $upload_error = "Failed to upload the file. Please try again.";
            }
        }
    } else {
        $upload_error = "File upload error: " . ($_FILES['art_img']['error'] ?? 'No file selected.');
    }

    // If upload fails, set an error message
    if ($upload_error) {
        $error_message = $upload_error;
        header("Location: add_art.php?status=error");
        exit;
    } else {
        // Check if artist_id exists in artist_info table
        $artist_check_query = $conn->prepare("SELECT artist_id FROM artist_info WHERE artist_id = ?");
        $artist_check_query->bind_param("i", $artist_id);
        $artist_check_query->execute();
        $artist_check_query->store_result();

        if ($artist_check_query->num_rows > 0) {
            // Insert into art_gallery if artist_id exists
            $stmt = $conn->prepare(
                "INSERT INTO art_gallery 
                (art_name, art_description, art_img, art_init_price, artist_id, creation_date) 
                VALUES (?, ?, ?, ?, ?, NOW())"
            );

            $stmt->bind_param(
                "sssdi",
                $art_name,
                $art_description,
                $image_path,
                $art_init_price,
                $artist_id
            );

            if ($stmt->execute()) {
                header("Location: Artist_dashboard.php");
                exit;
            } else {
                $error_message = "Error adding art: " . $stmt->error;
                header("Location: add_art.php?status=error");
                exit;
            }

            $stmt->close();
        } else {
            $error_message = "Error: Artist ID $artist_id does not exist. Please add the artist first.";
            header("Location: add_art.php?status=error");
            exit;
        }

        $artist_check_query->close();
    }
}

$conn->close();
?>