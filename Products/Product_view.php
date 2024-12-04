<?php
include "../Header_Footer/fixed_header.php";

include '../Database_Connection/DB_Connection.php';

// Sanitize and validate the product ID
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Fetch product details securely using a prepared statement
$sql = "SELECT * FROM product_info WHERE Product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
  die("<h1>Product not found.</h1>");
}

// Check session for logged-in status and user type
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
$isCustomer = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'customer_info';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ZenithZone</title>
  <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
  <main class="flex-grow container mx-auto px-4 py-8">
    <div class="flex flex-col mt-48 sm:mt-36 md:flex-row items-center md:items-start text-center md:text-left">
      <!-- Product Image -->
      <div class="md:w-1/2 flex flex-col items-center">
        <div class="big-img mb-4">
          <img id="bigImg" src="<?php echo htmlspecialchars($product['Product_image_path']); ?>" alt="<?php echo htmlspecialchars($product['Product_name']); ?>" style="width: 300px; height: 300px; object-fit: cover;" class="rounded-lg shadow-lg" onclick="toggleImagePreview()" />

        </div>
      </div>

      <!-- Product Details -->
      <div class="md:w-1/2 md:ml-8 mt-8 md:mt-0 flex flex-col items-center md:items-start">
        <div class="pname text-3xl font-bold mb-2 mt-5"><?php echo htmlspecialchars($product['Product_name']); ?></div>
        <!-- Rating -->
        <div class="ratings text-yellow-500 mb-2">
          <?php
          $fullStars = floor($product['Rating']);
          $halfStar = ($product['Rating'] - $fullStars) >= 0.5 ? 1 : 0;
          $emptyStars = 5 - ($fullStars + $halfStar);

          for ($i = 0; $i < $fullStars; $i++) {
            echo '<i class="fas fa-star"></i>';
          }
          if ($halfStar) {
            echo '<i class="fas fa-star-half-alt"></i>';
          }
          for ($i = 0; $i < $emptyStars; $i++) {
            echo '<i class="far fa-star"></i>';
          }
          ?>
        </div>
        <!-- Price -->
        <div class="price text-2xl font-semibold mb-4">
          <p class="font-bold text-red-500">
            ৳ <?= htmlspecialchars($product['New_price']) ?>
            <span class="line-through text-gray-500 ml-2">৳ <?= htmlspecialchars($product['Old_price']) ?></span>
            <span class="text-green-500">-<?= round((1 - $product['New_price'] / $product['Old_price']) * 100) ?>%</span>
          </p>
        </div>

        <!-- Description -->
        <div class="size mb-4">
          <p class="text-gray-700 font-semibold">Description:</p>
          <p class="text-gray-700 leading-relaxed"><?php echo nl2br(htmlspecialchars($product['Product_Description'])); ?></p>
        </div>

        <!-- Quantity Section -->
        <div class="quantity mb-6 flex flex-col items-center md:flex-row md:items-center">
          <p class="text-gray-700 font-semibold mr-4">Quantity:</p>
          <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded-lg shadow-md">
            <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full hover:bg-gray-300 transition duration-200" onclick="updateQuantity('decrement')">
              <i class="fas fa-minus"></i>
            </button>
            <input type="number" id="quantityInput" min="1" max="5" value="1" class="border-none text-center w-12 bg-white text-gray-700 font-semibold rounded-md focus:outline-none" />
            <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full hover:bg-gray-300 transition duration-200" onclick="updateQuantity('increment')">
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="btn-box flex space-x-4">
          <button
            class="wishlist-btn bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded-lg hover:from-red-500 hover:to-orange-500 transition duration-300 flex items-center space-x-2 shadow-md" onclick="addToWishlist()">
            <i class="far fa-heart"></i>
            <span>Wishlist</span>
          </button>
          <button class="cart-btn bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-blue-500 transition duration-300 flex items-center space-x-2 shadow-md" onclick="addToCart()">
            <i class="fas fa-shopping-cart"></i>
            <span>Add to Cart</span>
          </button>

          <button class="buy-btn bg-gradient-to-r from-green-500 to-green-700 text-white px-6 py-2 rounded-lg hover:from-green-700 hover:to-green-500 transition duration-300 flex items-center space-x-2 shadow-md"
            onclick="redirectToBuyNow()">
            <i class="fas fa-bolt"></i>
            <span>Buy Now</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Customer Reviews Section -->
    <div class="customer-reviews border border-gray-200 rounded-lg p-6 mt-10 shadow-sm">
      <h6 class="text-lg font-bold mb-6">Customer Reviews</h6>
      <div class="flex items-start mb-6">
        <div class="flex-shrink-0">
          <img src="./img/user-icon.png" alt="User Avatar" class="w-12 h-12 rounded-full shadow-md" />
        </div>
        <div class="ml-4">
          <div class="text-gray-800 font-semibold">Abir Mahmud</div>
          <div class="text-gray-600 mb-1">
            Rated <span class="text-yellow-500">★★★★☆</span>
          </div>
          <p class="text-gray-700">"Great T-shirt! Fits perfectly and feels very comfortable."</p>
        </div>
      </div>
    </div>

  </main>

  <!-- Modal Structure -->
  <div id="messageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-5 shadow text-center">
      <i id="modalIcon" class="fas fa-exclamation-circle fa-5x text-red-500"></i>
      <h3 id="modalTitle" class="text-lg font-bold mt-4">Title Here</h3>
      <p id="modalMessage" class="mt-2">Message Here</p>
      <button onclick="hideModal()" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Close</button>
    </div>
  </div>

  <script>
    // Function to hide the modal
    function hideModal() {
      document.getElementById('messageModal').classList.add('hidden');
    }
  </script>


  <script>
    var isLoggedIn = <?php echo json_encode($isLoggedIn && $isCustomer); ?>;

    function redirectToBuyNow() {
      var quantity = document.getElementById('quantityInput').value;
      var productId = <?= $product_id; ?>;
      if (isLoggedIn) {
        // If logged in and is a customer, redirect to the buy now page
        var url = '../Buy/BuyNow.php?product_id=' + productId + '&quantity=' + quantity;
        window.location.href = url;
      } else {
        // If not logged in or not a customer, show the modal
        showModal('Please Log In', 'You must be logged in as a customer to proceed with the purchase.');
      }
    }

    function showModal(title, message) {
      document.getElementById('modalTitle').textContent = title;
      document.getElementById('modalMessage').textContent = message;
      document.getElementById('messageModal').classList.remove('hidden'); // Show the modal
    }

    function addToCart() {
      var productId = <?= $product_id; ?>;
      if (isLoggedIn) {
        // If logged in, redirect to the buy now page
        var url = '../Cart/add_to_cart.php?product_id=' + productId;
        window.location.href = url;
      } else {
        // If not logged in, show the modal
        showModal('Please Log In', 'You must be logged in as a customer to add cart');
      }
      // Construct the URL with query parameters  
    }
    function addToWishlist() {
      var productId = <?= $product_id; ?>;
      if (isLoggedIn) {
        // If logged in, redirect to the buy now page
        var url = '../Wishlist/add_to_wishlist.php?product_id=' + productId;
        window.location.href = url;
      } else {
        // If not logged in, show the modal
        showModal('Please Log In', 'You must be logged in as a customer to add Wishlist');
      }
      // Construct the URL with query parameters  
    }
  </script>
  <script src="./assets/js/script.js"></script>
  <script src="./Product_view.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <?php include "../Header_Footer/footer.php"; ?>
</body>

</html>