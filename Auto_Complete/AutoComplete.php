<?php
include '../Database_Connection/DB_Connection.php';


if (isset($_GET['term'])) {
    $searchTerm = $_GET['term'] ?? '';
    $searchTerm = $searchTerm . '%';

    $query = $conn->prepare("
        SELECT DISTINCT Product_category FROM product_info WHERE Product_category LIKE ? 
        UNION 
        SELECT DISTINCT Product_name FROM product_info WHERE Product_name LIKE ? 
        LIMIT 5
    ");
    $query->bind_param("ss", $searchTerm, $searchTerm);
    $query->execute();
    $result = $query->get_result();

    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = reset($row); // Get the first column (either category or name)
    }

    echo json_encode($suggestions);
    $query->close();
    // $conn->close();
    exit;
}
?>
