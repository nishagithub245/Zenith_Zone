<?php
include('../Database_Connection/DB_Connection.php'); // Include database connection

// Get the search query from the request (user input)
$search_query = isset($_GET['query']) ? $_GET['query'] : '';

// Initialize the response array
$response = [];

if (!empty($search_query)) {
    // Sanitize the search query to prevent SQL injection
    $search_query = mysqli_real_escape_string($conn, $search_query);

    // SQL query to fetch categories that match the user's input
    $sql = "SELECT DISTINCT product_category FROM product_info WHERE product_category LIKE '%$search_query%' LIMIT 10";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Fetch matching categories and add them to the response array
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row['product_category'];
        }
    } else {
        // Handle SQL query error
        $response['error'] = 'Error fetching category suggestions: ' . mysqli_error($conn);
    }
} else {
    $response['error'] = 'No search query provided';
}

// Close the database connection
mysqli_close($conn);

// Return the response as JSON
echo json_encode($response);
?>
