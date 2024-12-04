<?php
session_start();
include_once"../Database_Connection/DB_Connection.php";

// Extract user type and ID from session
$user_type = $_SESSION['user_type'];
$user_id = $_SESSION['user_id'];

// Fetch second-hand product ID from the URL parameter
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

$userDetails = getUserDetails($conn, $user_type, $user_id);
$product = getProductDetails($conn, $product_id);


// Retrieve user details
function getUserDetails($mysqli, $userType, $userId)
{
  $tables = [
    'artist_info' => 'artist_id',
    'customer_info' => 'customer_id',
    'sellersinfo' => 'seller_id'
  ];
  $idColumn = $tables[$userType] ?? null;
  if (!$idColumn) {
    return null;
  }
  $stmt = $mysqli->prepare("SELECT first_name, last_name, mobile_number, address FROM {$userType} WHERE {$idColumn} = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($details = $result->fetch_assoc()) {
    $stmt->close();
    return $details;
  }
  $stmt->close();
  return null; // Return null if user not found
}


// Function to fetch second-hand product details
function getProductDetails($conn, $product_id)
{
  $stmt = $conn->prepare("SELECT Sh_product_name, Sh_image_path, Sh_Product_description, Sh_price FROM second_hand_product WHERE Sh_product_id = ?");
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($product = $result->fetch_assoc()) {
    $stmt->close();
    return $product;
  }
  $stmt->close();
  return null; 
}

$itemTotal = $product['Sh_price']; 
$quantity = 1; 

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ZenithZone</title>
  <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</head>

<body class="font-poppins bg-gray-100 text-gray-800">
  <?php include "../Header_Footer/fixed_header.php"; ?>

  <div class="max-w-5xl mt-48 sm:mt-36 mx-auto p-4 lg:p-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column (Shipping & Billing and Package Details) -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Shipping & Billing Section -->
      <div class="bg-white rounded-lg p-6 shadow-sm">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
          <h2 class="text-lg font-semibold text-gray-800">
            Shipping & Billing
          </h2>
        </div>
        <div>
          <p class="font-semibold"><?= htmlspecialchars($userDetails['first_name']) . ' ' . htmlspecialchars($userDetails['last_name']); ?></p>
          <p class="text-sm text-gray-600"><?= htmlspecialchars($userDetails['mobile_number']); ?></p>
          <p
            id="address-type"
            class="inline-flex items-center bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full mt-2 mb-4">
            <i id="address-icon" class="fas fa-home mr-2"></i> Home
          </p>
          <p><?= htmlspecialchars($userDetails['address']); ?></p>
        </div>

        <!-- Pickup Info with Dropdown -->
        <div
          class="bg-blue-50 border border-blue-300 rounded-md p-4 mt-4 cursor-pointer"
          onclick="toggleDropdown()">
          <p class="text-sm text-blue-700">
            Collect your parcel from the nearest Pick-up Point with a
            reduced shipping fee
          </p>
          <span class="text-xs text-gray-500">3 suggested collection point(s) nearby</span>

          <!-- Dropdown for Pick-up Points -->
          <div id="pickup-dropdown" class="hidden mt-2 space-y-2">
            <label class="block">
              <input
                type="radio"
                name="pickup-option"
                onclick="selectPickupPoint('Point A')"
                class="mr-2" />
              Fardaous vila, Johurul hoq miar garej, word no: 5 Noakhali
              porosova
            </label>
            <label class="block">
              <input
                type="radio"
                name="pickup-option"
                onclick="selectPickupPoint('Point B')"
                class="mr-2" />
              Noakhali Post Office Collection Point, Maijdee Court, DC Office
              Road
            </label>
            <label class="block">
              <input
                type="radio"
                name="pickup-option"
                onclick="selectPickupPoint('Point C')"
                class="mr-2" />
              Maijdee Collection Point , Fozia Villa, New Police Line Road,
              Maijdee bazar
            </label>
          </div>
        </div>
      </div>

      <!-- Package Details Section -->
      <div class="bg-white rounded-lg p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-4">
          Package 1 of 1
        </h3>
        <div class="flex items-start space-x-4 mb-6">
          <input
            type="radio"
            id="standard"
            name="delivery"
            checked
            class="mt-1.5 border-gray-300 text-blue-600"
            disabled />
          <div>
            <p class="font-medium">
              <span id="delivery-fee">৳ 120</span> - Standard Delivery
            </p>
            <p class="text-sm text-gray-500" id="guaranteed-delivery-date">Guaranteed by </p>
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <img
            src="<?= htmlspecialchars($product['Sh_image_path']) ?>"
            alt="<?= htmlspecialchars($product['Sh_product_name']) ?>"
            class="w-32 h-auto rounded-lg" />
          <div class="text-sm">
            <p class="font-medium">
              <?= htmlspecialchars($product['Sh_product_name']) ?>
            </p>
            <p class="text-gray-500"><?= htmlspecialchars($product['Sh_Product_description']) ?></p>
            <p class="font-bold text-red-500">
              ৳ <?= htmlspecialchars($product['Sh_price']) ?>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column (Promotion and Order Summary) -->
    <div class="space-y-6">
      <!-- Order Summary Section -->
      <div class="bg-white rounded-lg p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
          Order Summary
        </h2>
        <div class="space-y-1 text-sm">
          <p class="flex justify-between">
            Items Total (<?= $quantity ?> Item<?= $quantity > 1 ? 's' : '' ?>): <span id="itemTotal">৳ <?= number_format($itemTotal, 2) ?></span>
          </p>
          <p class="flex justify-between">
            Delivery Fee: <span id="delivery-fees">৳ 120</span>
          </p>
        </div>
        <hr class="my-2" />
        <p class="flex justify-between font-bold text-lg">
          Total: <span id="order-summary-total">৳ <?= number_format($itemTotal + 120, 2); ?></span>
        </p>
        <p class="text-xs text-gray-500">VAT included, where applicable</p>
        <button
          onclick="redirectToPayment()"
          class="w-full bg-orange-500 text-white py-3 rounded-md text-sm font-semibold mt-4 hover:bg-orange-600 transition">
          Proceed to Pay
        </button>
      </div>
    </div>
  </div>
  <?php include "../Header_Footer/footer.php"; ?>

  <script>
    function toggleDropdown() {
      document.getElementById("pickup-dropdown").classList.toggle("hidden");
    }

    function selectPickupPoint(point) {
      document.getElementById("address-type").classList.replace("bg-red-500", "bg-blue-500");
      document.getElementById("address-icon").className = "fas fa-map-marker-alt mr-2";
      document.getElementById("address-type").innerHTML = `<i class="fas fa-map-marker-alt mr-2"></i> Pick-up`;
      const deliveryFee = 40; // Set the new delivery fee for pickup
      document.getElementById('delivery-fee').innerText = `৳ ${deliveryFee}`;
      document.getElementById('delivery-fees').innerText = `৳ ${deliveryFee}`;
      updateOrderSummary(); // Update the order summary to reflect new fee
    }

    function updateOrderSummary() {
      var itemTotal = <?= $itemTotal ?>;
      var deliveryFee = parseInt(document.getElementById('delivery-fee').innerText.replace('৳ ', ''));
      var total = itemTotal + deliveryFee;

      document.getElementById('itemTotal').innerText = `৳ ${itemTotal.toFixed(2)}`;
      document.getElementById('order-summary-total').innerText = `৳ ${total.toFixed(2)}`;
    }

    function redirectToPayment() {
      var userId = <?= json_encode($user_id); ?>; // Get user ID from PHP
      var productId = <?= json_encode($product_id); ?>; // Get product ID from PHP
      var totalAmount = document.getElementById('order-summary-total').textContent.replace('৳ ', '').trim(); // Get total from the order summary
      var quantity = <?= $quantity ?>; // Get quantity from PHP
      var userType = <?= json_encode($user_type); ?>; // Get user type from PHP

      // Construct the URL with query parameters
      var url = './Payment.php?user_id=' + encodeURIComponent(userId) +
        '&product_id=' + encodeURIComponent(productId) +
        '&total_amount=' + encodeURIComponent(totalAmount) +
        '&quantity=' + encodeURIComponent(quantity) +
        '&user_type=' + encodeURIComponent(userType);

      // Redirect to the payment page with parameters
      window.location.href = url;
    }
  </script>
</body>

</html>