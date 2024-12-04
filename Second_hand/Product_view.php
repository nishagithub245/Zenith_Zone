<?php
// session_start(); 
include "../Header_Footer/fixed_header.php";

$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
include '../Database_Connection/DB_Connection.php';  

// Change to fetch data from the second_hand_product table
$sql = "SELECT * FROM second_hand_product WHERE Sh_product_id = $product_id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

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
          <img id="bigImg" src="<?php echo htmlspecialchars($product['Sh_image_path']); ?>" alt="<?php echo htmlspecialchars($product['Sh_product_name']); ?>" style="width: 300px; height: 300px; object-fit: cover;" class="rounded-lg shadow-lg" onclick="toggleImagePreview()" />
        </div>
      </div>

      <!-- Product Details -->
      <div class="md:w-1/2 md:ml-8 mt-8 md:mt-0 flex flex-col items-center md:items-start">
        <div class="pname text-3xl font-bold mb-2 mt-5"><?php echo htmlspecialchars($product['Sh_product_name']); ?></div>
        <!-- Description -->
        <div class="description text-xl mb-2">
          <p class="font-semibold text-gray-700">Description:</p>
          <p><?php echo nl2br(htmlspecialchars($product['Sh_Product_description'])); ?></p>
        </div>
        <!-- Present Condition -->
        <div class="condition text-xl mb-4">
          <p class="font-semibold text-gray-700">Present Condition:</p>
          <p><?php echo htmlspecialchars($product['Sh_Product_present_condition']); ?></p>
        </div>
        <!-- Price -->
        <div class="price text-2xl font-semibold mb-4">
          <p class="font-bold text-red-500">
            ৳ <?= htmlspecialchars($product['Sh_price']) ?>
          </p>
        </div>
        <!-- Action Button -->
        <div class="btn-box flex space-x-4">
        <button class="cart-btn bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-blue-500 transition duration-300 flex items-center space-x-2 shadow-md"
            onclick="addToCart()">
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
  </main>

   <!-- Full Image View Modal -->
   <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50">
    <img id="modalImg" src="" class="max-w-full max-h-full" alt="Full Size Product Image">
    <button onclick="hideFullImage()" class="absolute top-0 right-0 text-white text-2xl p-2">&times;</button>
  </div>

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
    var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    function redirectToBuyNow() {
      var productId = <?= $product_id; ?>;
      if (isLoggedIn) {
        // If logged in, redirect to the buy now page
        var url = './S_BuyNow.php?product_id=' + productId;
        window.location.href = url;
      } else {
        // If not logged in, show the modal
        showModal('Please Log In', 'You must be logged in to proceed with the purchase.');
      }
    }

    function showModal(title, message) {
      document.getElementById('modalTitle').textContent = title;
      document.getElementById('modalMessage').textContent = message;
      document.getElementById('messageModal').classList.remove('hidden'); // Show the modal
    }
  </script>
  <script src="./assets/js/script.js"></script>
  <script src="./Product_view.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <?php include "../Header_Footer/footer.php"; ?>
</body>

</html>