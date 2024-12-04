<?php
include('../Database_Connection/DB_Connection.php'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form inputs
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_description = $_POST['product_description'];
    $stock_quantity = $_POST['stock_quantity'];
    $old_price = $_POST['old_price'];
    $new_price = $_POST['new_price'];

    // Generate product code (first 3 letters of category + auto increment number)
    $category_code = substr(strtolower($product_category), 0, 3);  // Get first 3 letters of the category
    $sql = "SELECT MAX(CAST(SUBSTRING(product_code, 4) AS UNSIGNED)) AS max_code FROM product_info WHERE product_code LIKE '$category_code%'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $max_code = $row['max_code'] + 1;
    $product_code = $category_code . str_pad($max_code, 3, '0', STR_PAD_LEFT);  // Example: ele001, ele002, ...

    // Handle image upload
    $target_dir = "../Products/$product_category/";  // Directory where images will be saved
    $image_extension = pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION);  // Get file extension
    $target_file = $target_dir . $product_code . '.' . $image_extension;  // Image path: product_code.extension

    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');  // Allowed image formats

    // Check if the image type is allowed
    if (in_array(strtolower($image_extension), $allowed_types)) {
        // Try to upload the image
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // Image uploaded successfully
            $product_image_path = "../Products/$product_category/$product_code.$image_extension";  // Correct image path format
        } else {
            echo json_encode(["status" => "error", "message" => "Sorry, there was an error uploading your file."]);
            exit;
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."]);
        exit;
    }

    // Insert data into the database
    $sql_insert = "INSERT INTO product_info (Product_name, Product_category, Product_description, Product_code, Product_image_path, Stock_quantity, Old_price, New_price, Stock_status, Rating) 
                   VALUES ('$product_name', '$product_category', '$product_description', '$product_code', '$product_image_path', '$stock_quantity', '$old_price', '$new_price', 
                   IF('$stock_quantity' > 0, 'Yes', 'No'), 0)";

    if (mysqli_query($conn, $sql_insert)) {
        echo json_encode(['status' => 'success', 'message' => 'Product added successfully']);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . mysqli_error($conn)]);
    }
    // Close the connection
    mysqli_close($conn);
}
