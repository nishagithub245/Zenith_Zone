<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ZenithZone - eCommerce Website</title>
  <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="./backgorund.css">
</head>

<body>
  <canvas class="background-canvas" id="backgroundCanvas"></canvas>
  <?php include '../Header_Footer/fixed_header.php'; ?>
  <main>
    <?php include './banner.php'; ?>

    <?php
    $user_gender = isset($_GET['gender']) ? $_GET['gender'] : '';

$male_categories = ["Shirt", "Pant", "Watch", "Shoe", "Wallet", "Skincare Product"];
$female_categories = ["Saree", "Perfume", "Bag", "Necklace", "Makeup", "Earring", "Skincare Product"];

// Start with fetching the products for the user’s gender
if ($user_gender == 'male') {
    $categories = implode("', '", $male_categories);
} else {
    $categories = implode("', '", $female_categories);
}

$start = 0;
$limit = 20;

// Query for the user's gender-specific categories
$sql_gender = "SELECT * FROM product_info WHERE product_category IN ('$categories') ORDER BY RAND() LIMIT $start, $limit";
$result_gender = $conn->query($sql_gender);
    echo '<div class="container mx-auto px-4">
      <div class="flex flex-col">
        <div class="text-center py-6">
          <h2 class="text-3xl font-bold text-gray-800 mb-6">New Products</h2>
          <div id="productGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">';

          if ($result_gender->num_rows > 0) {
            while ($row = $result_gender->fetch_assoc()) {
        echo '<div class="bg-white shadow-lg rounded-lg overflow-hidden relative group hover:border-red-500 hover:border-2 transition duration-300 w-48">
              <a href="../Products/Product_view.php?product_id=' . $row["Product_id"] . '">
                  <img src="' . $row["Product_image_path"] . '" alt="' . htmlspecialchars($row["Product_name"]) . '" class="w-full h-32 object-cover transition duration-300 ease-in-out">
              </a>
              <div class="absolute inset-y-0 right-0 flex flex-col items-center justify-center gap-2 transform translate-x-full transition-transform duration-300 ease-in-out group-hover:translate-x-0 bg-black bg-opacity-0 p-2">
                <button class="text-blue-500 text-md p-0.5 rounded"><i class="far fa-heart"></i></button>
                <a href="../Products/Product_view.php?product_id=' . $row["Product_id"] . '" class="text-blue-500 text-md p-0.5 rounded inline-block">
                  <i class="far fa-eye"></i>
                </a>
                <button class="text-blue-500 text-md p-0.5 rounded"><i class="fas fa-shopping-bag"></i></button>
              </div>
              <div class="p-2">
                <a href="../Products/Product_view.php?product_id=' . $row["Product_id"] . '" class="inline-block text-blue-500 hover:text-blue-600 text-sm">' . strtoupper($row["Product_name"]) . '</a>
                <div class="flex items-center mb-1">';
        for ($i = 0; $i < 5; $i++) {
          if ($i < floor($row["Rating"])) {
            echo '<i class="fas fa-star text-yellow-400"></i>';
          } elseif ($i < ceil($row["Rating"])) {
            echo '<i class="fas fa-star-half-alt text-yellow-400"></i>';
          } else {
            echo '<i class="far fa-star text-yellow-400"></i>';
          }
        }
        echo '</div>
                <div class="flex items-baseline space-x-1 font-bold">
                  <p class="text-sm text-blue-500">৳' . $row["New_price"] . '</p>
                  <del class="text-xs text-gray-400">৳' . $row["Old_price"] . '</del>
                  <p class="text-green-500">-' . round((1 - $row['New_price'] / $row['Old_price']) * 100) . '%</p>
                </div>
              </div>
            </div>';
      }
    } else {
      echo "<p>No products found</p>";
    }

    echo '</div>
        <button id="loadMore" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4  mt-6 mb-6 rounded">
          Show More
        </button>
      </div>
    </div>
  </div>';
    $conn->close();
    ?>
  </main>

  <?php include '../Header_Footer/footer.php'; ?>

  <script>
    let start = <?php echo $start; ?>;
    const limit = <?php echo $limit; ?>;

    document.getElementById("loadMore").addEventListener("click", function() {
      start += limit;

      $.ajax({
        url: "load_more_products.php",
        type: "GET",
        data: {
          start: start,
          limit: limit
        },
        success: function(data) {
          if (data) {
            $("#productGrid").append(data);
          } else {
            $("#loadMore").hide();
          }
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error:", xhr.responseText);
          alert("Failed to load more products.");
        }
      });
    });
  </script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="./background.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>