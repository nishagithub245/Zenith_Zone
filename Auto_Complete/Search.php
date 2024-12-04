<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenithZone</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php
    include_once "../Header_Footer/fixed_header.php";

    // Define a utility function for sanitizing input
    if (!function_exists('sanitizeInput')) {
        function sanitizeInput($input)
        {
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
        }
    }
    // Get the search query from the URL or POST request
    $searchValue = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';

    // Initialize the search term with wildcards for LIKE queries
    $searchTerm = '%' . $searchValue . '%';

    // Check if the search query matches any product category first
    $sqlCategory = "SELECT DISTINCT Product_category FROM product_info WHERE Product_category LIKE ?";
    $stmt = $conn->prepare($sqlCategory);
    $stmt->bind_param('s', $searchTerm);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Category match found, fetch all products in that category
        $stmt->bind_result($categoryName);
        $stmt->fetch();
        $sqlProducts = "SELECT Product_name, Product_image_path, Product_id, New_price, Old_price, Rating 
                    FROM product_info WHERE Product_category = ?";
        $stmtProducts = $conn->prepare($sqlProducts);
        $stmtProducts->bind_param('s', $categoryName);
        $stmtProducts->execute();
        $stmtProducts->store_result();
    } else {
        // No category match found, search by product name
        $sqlProducts = "SELECT Product_name, Product_image_path, Product_id, New_price, Old_price, Rating 
                    FROM product_info WHERE Product_name LIKE ?";
        $stmtProducts = $conn->prepare($sqlProducts);
        $stmtProducts->bind_param('s', $searchTerm);
        $stmtProducts->execute();
        $stmtProducts->store_result();

        // If no products found by name, perform a fuzzy search (MATCH AGAINST) for most similar products
        if ($stmtProducts->num_rows == 0) {
            $sqlFuzzySearch = "SELECT Product_name, Product_image_path, Product_id, New_price, Old_price, Rating 
                           FROM product_info WHERE MATCH(Product_name) AGAINST(?)";
            $stmtFuzzySearch = $conn->prepare($sqlFuzzySearch);
            $stmtFuzzySearch->bind_param('s', $searchValue);
            $stmtFuzzySearch->execute();
            $stmtFuzzySearch->store_result();

            // Check if any fuzzy search results were found
            if ($stmtFuzzySearch->num_rows > 0) {
                $stmtProducts = $stmtFuzzySearch; // Use fuzzy search results for displaying products
            }
        }
    }

    // Display the products
    echo '<div class="container mx-auto px-4 mt-44 sm:mt-36">
      <div class="flex flex-col">
        <div class="text-center py-6">
          <h2 class="text-3xl font-bold text-gray-800 mb-6">Search Results for "' . htmlspecialchars($searchValue) . '"</h2>
          <div id="productGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">';

    if ($stmtProducts->num_rows > 0) {
        $stmtProducts->bind_result($productName, $productImagePath, $productId, $newPrice, $oldPrice, $rating);
        while ($stmtProducts->fetch()) {
            echo '<div class="bg-white shadow-lg rounded-lg overflow-hidden relative group hover:border-red-500 hover:border-2 transition duration-300 w-48">
              <a href="../Products/Product_view.php?product_id=' . $productId . '">
                  <img src="' . $productImagePath . '" alt="' . htmlspecialchars($productName) . '" class="w-full h-32 object-cover transition duration-300 ease-in-out">
              </a>
              <div class="absolute inset-y-0 right-0 flex flex-col items-center justify-center gap-2 transform translate-x-full transition-transform duration-300 ease-in-out group-hover:translate-x-0 bg-black bg-opacity-0 p-2">
                <button class="text-blue-500 text-md p-0.5 rounded"><i class="far fa-heart"></i></button>
                <a href="../Products/Product_view.php?product_id=' . $productId . '" class="text-blue-500 text-md p-0.5 rounded inline-block">
                  <i class="far fa-eye"></i>
                </a>
                <button class="text-blue-500 text-md p-0.5 rounded"><i class="fas fa-shopping-bag"></i></button>
              </div>
              <div class="p-2">
                <a href="../Products/Product_view.php?product_id=' . $productId . '" class="inline-block text-blue-500 hover:text-blue-600 text-sm">' . strtoupper($productName) . '</a>
                <div class="flex items-center mb-1">';
            for ($i = 0; $i < 5; $i++) {
                if ($i < floor($rating)) {
                    echo '<i class="fas fa-star text-yellow-400"></i>';
                } elseif ($i < ceil($rating)) {
                    echo '<i class="fas fa-star-half-alt text-yellow-400"></i>';
                } else {
                    echo '<i class="far fa-star text-yellow-400"></i>';
                }
            }
            echo '</div>
                <div class="flex items-baseline space-x-1 font-bold">
                  <p class="text-sm text-blue-500">৳' . number_format($newPrice, 2) . '</p>
                  <del class="text-xs text-gray-400">৳' . number_format($oldPrice, 2) . '</del>
                  <p class="text-green-500">-' . round((1 - $newPrice / $oldPrice) * 100) . '%</p>
                </div>
              </div>
            </div>';
        }
    } else {
        echo "<p>No products found matching your search criteria.</p>";
    }

    echo '</div>

    </div>
  </div>
</div>';

    include_once "../Header_Footer/footer.php";

    $stmt->close();
    $stmtProducts->close();
    // $conn->close();
    ?>
</body>

</html>