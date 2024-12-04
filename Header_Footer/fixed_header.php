<?php
session_start();
include "../Database_Connection/DB_Connection.php";

// Sanitize and validate input
function sanitizeInput($input)
{
  return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Handle AJAX requests from Login.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $loggedin = isset($_POST['loggedin']) ? filter_var($_POST['loggedin'], FILTER_VALIDATE_BOOLEAN) : null;
  $user_type = isset($_POST['user_type']) ? sanitizeInput($_POST['user_type']) : null;
  $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;

  // Store received data in the session
  if ($loggedin !== null) {
    $_SESSION['loggedin'] = $loggedin;
  }
  if ($user_type !== null) {
    $_SESSION['user_type'] = $user_type;
  }
  if ($user_id !== null) {
    $_SESSION['user_id'] = $user_id;
  }

  // Optional: Respond back to the AJAX request
  echo json_encode(['status' => 'success', 'message' => 'Data received and stored successfully']);
  exit(); // Stop further script execution after processing the AJAX request
}

function getUserFirstName($conn, $userType, $userId)
{
  $tableName = '';
  $idColumn = '';
  $firstNameColumn = 'first_name';

  // Determine the table based on user type
  switch ($userType) {
    case 'artist_info':
      $tableName = 'artist_info';
      $idColumn = 'artist_id';
      break;
    case 'customer_info':
      $tableName = 'customer_info';
      $idColumn = 'customer_id';
      break;
    case 'sellersinfo':
      $tableName = 'sellersinfo';
      $idColumn = 'seller_id';
      break;
    default:
      return 'Guest'; // Return 'Guest' if no valid user type
  }

  // Prepare and execute the query
  $sql = "SELECT {$firstNameColumn} FROM {$tableName} WHERE {$idColumn} = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($firstName);
    if ($stmt->fetch()) {
      $stmt->close();
      return $firstName;
    }
    $stmt->close();
  }
  return 'User'; // Return 'User' if no name is found or on error
}

// Session validation and user information
$loggedInStatus = $_SESSION['loggedin'] ?? false;
$userType = $_SESSION['user_type'] ?? 'Guest';
$userId = $_SESSION['user_id'] ?? 0;
$firstName = $loggedInStatus ? getUserFirstName($conn, $userType, $userId) : 'Guest';

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  session_unset();
  session_destroy();
  header("Location: ../Homepage/InitialPage1.php");
  exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ZenithZone</title>
  <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">
  <link rel="stylesheet" href="../Auto_Complete/AutoComplete.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <?php
  include '../Auto_Complete/AutoComplete.php';
  ?>
  <header>
    <!-- This first nav bar -->
    <!-- Fixed navigation bar with interactive animated background -->
    <div class="fixed top-0 left-0 right-0 z-50 group">
      <!-- Animated gradient background with hover effect -->
      <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-violet-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200">
      </div>
      <!-- Navigation content -->
      <div class="relative bg-[#363b41] py-5 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col sm:flex-row justify-between items-center">
            <!-- Logo -->
            <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ? '../HomePage/Personalized_products.php' : '../HomePage/InitialPage1.php'; ?>" class="flex-shrink-0">
              <img src="../assets/images/logo/ZenithZone.png" alt="ZenithZone logo" class="h-16 sm:h-20" />
            </a>

            <!-- Search Field For Large Device -->
            <div class="flex-grow mx-10 my-2 sm:my-0 hidden md:block">
              <div class="relative hidden md:block">
                <input type="search" id="searchInput" name="search" class="input-field w-full pl-4 pr-20 py-2 border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border rounded-md" placeholder="Enter your product name..." onkeydown="checkEnter(event)" />

                <!-- Autocomplete Suggestions Box -->
                <ul id="searchSuggestions" class="autobox absolute z-10 bg-white w-full shadow-lg max-h-60 overflow-y-auto"></ul>

                <!-- Search Button -->
                <button class="absolute inset-y-0 right-10 px-3 flex items-center" onclick="handleSearch()">
                  <ion-icon name="search-outline" class="h-5 w-5 text-gray-500"></ion-icon>
                </button>

                <!-- Voice Search Button -->
                <button id="voiceSearchButton" class="absolute inset-y-0 right-0 px-3 flex items-center">
                  <ion-icon name="mic-outline" class="h-5 w-5 text-gray-500"></ion-icon>
                </button>
              </div>
            </div>



            <!-- User Actions and Authentication -->
            <div class="flex items-center space-x-4 mt-2 sm:mt-0">
              <!-- Authentication Links -->
              <?php if ($loggedInStatus): ?>
                <a href="?action=logout" class="text-[#fbad62] hover:text-white transition duration-150 ease-in-out">Logout</a>
                <a href="<?php
                          if ($userType === 'customer_info') {
                            echo '../Customer_dashboard/Customers_dashboard.php?userId=' . $userId;
                          } elseif ($userType === 'artist_info') {
                            echo '../Artist_dashboard/Artist_dashboard.php?userId=' . $userId;
                          } elseif ($userType === 'sellersinfo') {
                            echo '../Seller_dashboard/Seller_dashboard.php?userId=' . $userId;
                          } else {
                            echo '../Customer_dashboard/Customers_dashboard.php?userId=' . $userId . '&user_type=' . $userType;
                          }
                          ?>" class="text-[#fbad62] hover:text-white transition duration-150 ease-in-out"><?= $firstName; ?></a>



              <?php else: ?>
                <a href="../Login/Login.php" class="text-[#fbad62] hover:text-white transition duration-150 ease-in-out">Login</a>
                <a href="../Registration/Who.php" class="text-[#fbad62] hover:text-white transition duration-150 ease-in-out">Signup</a>
              <?php endif; ?>
              <!-- User Actions -->
              <button class="text-[#fbad62] hover:text-white">
                <ion-icon name="person-outline" class="h-6 w-6"></ion-icon>
              </button>
              <button onclick="showWishList()" class="relative text-[#fbad62] hover:text-white">
                <ion-icon name="heart-outline" class="h-6 w-6"></ion-icon>
                <!-- <span class="absolute -top-2 -right-2 rounded-full bg-red-500 text-white text-xs px-2 py-1">0</span> -->
              </button>
              <!-- Add to cart -->
              <button onclick="showCartList()" class="relative text-[#fbad62] hover:text-white">
                <ion-icon name="bag-handle-outline" class="h-6 w-6"></ion-icon>
                <!-- <span class="absolute -top-2 -right-2 rounded-full bg-red-500 text-white text-xs px-2 py-1">0</span> -->
              </button>

            </div>
            <!-- Search Field for Small device  -->
            <div class="flex-grow mx-10 my-2 sm:my-0 block sm:hidden">
              <div class="relative">
                <input type="search" id="searchInput" name="search" class="input-field w-full pl-4 pr-20 py-2 border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border rounded-md" placeholder="Enter your product name..." onkeydown="checkEnter(event)" /> <!-- Autocomplete Suggestions Box -->
                <ul id="searchSuggestionsMobile" class="autobox absolute z-10 bg-white w-full shadow-lg max-h-60 overflow-y-auto"></ul>
                <!-- Search Button -->
                <button class="absolute inset-y-0 right-10 px-3 flex items-center" onclick="handleSearch()">
                  <ion-icon name="search-outline" class="h-5 w-5 text-gray-500"></ion-icon>
                </button>
                <!-- Voice Search Button -->
                <button id="voiceSearchButton" class="absolute inset-y-0 right-0 px-3 flex items-center">
                  <ion-icon name="mic-outline" class="h-5 w-5 text-gray-500"></ion-icon>
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Second nav -->
      <nav class="bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% hidden fixed top-[120px] sm:block w-full z-40">
        <div class="container mx-auto px-4 py-3">
          <ul class="flex flex-wrap justify-center items-center gap-6 lg:gap-8 xl:gap-10">
            <li>
              <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ? '../HomePage/Personalized_products.php' : '../HomePage/InitialPage1.php'; ?>" class="text-slate-50 font-bold hover:text-indigo-500">
                Home
              </a>
            </li>
            <li class="dropdown dropdown-hover">
              <div tabindex="0" role="button" class="text-slate-50 font-bold hover:text-indigo-500">
                Categories
              </div>
              <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-50 min-w-96 p-4 shadow grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                  <h3 class="font-semibold mb-2">Electronics</h3>
                  <ul class="space-y-1">
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Desktop</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Laptop</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Camera</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Tablet</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Headphone</a>
                    </li>
                  </ul>
                </div>
                <div>
                  <h3 class="font-semibold mb-2">Men's</h3>
                  <ul class="space-y-1">
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Formal</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Casual</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Sports</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Jacket</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Sunglasses</a>
                    </li>
                  </ul>
                </div>
                <div>
                  <h3 class="font-semibold mb-2">Women's</h3>
                  <ul class="space-y-1">
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Formal</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Casual</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Perfume</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Cosmetics</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Bags</a>
                    </li>
                  </ul>
                </div>
                <div>
                  <h3 class="font-semibold mb-2">Accessories</h3>
                  <ul class="space-y-1">
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Smart Watch</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Smart TV</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Keyboard</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Mouse</a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-600 hover:text-indigo-500">Microphone</a>
                    </li>
                  </ul>
                </div>
              </ul>
            </li>
            <li class="dropdown dropdown-hover">
              <div tabindex="0" role="button" class="text-slate-50 font-bold hover:text-indigo-500">
                <a href="../Art/ArtWelcome.php">Art or Craft</a>
              </div>

            </li>
            <li class="dropdown dropdown-hover">
              <div tabindex="0" role="button" class="text-slate-50 font-bold hover:text-indigo-500">
                <a href="../Second_hand/Second.php">Second Hand Products</a>
              </div>
            </li>
            <li class="dropdown dropdown-hover">
              <div tabindex="0" role="button" class="text-slate-50 font-bold hover:text-indigo-500">
                Men's
              </div>
              <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Shirt</a>
                </li>
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Shorts & Jeans</a>
                </li>
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Safety Shoes</a>
                </li>
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Wallet</a>
                </li>
              </ul>
            </li>
            <li class="dropdown dropdown-hover">
              <div tabindex="0" role="button" class="text-slate-50 font-bold hover:text-indigo-500">
                Women's
              </div>
              <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Dress & Frock</a>
                </li>
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Earrings</a>
                </li>
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Necklace</a>
                </li>
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Makeup Kit</a>
                </li>
              </ul>
            </li>
            <li class="dropdown dropdown-hover">
              <div tabindex="0" role="button" class="text-slate-50 font-bold hover:text-indigo-500">
                Kids
              </div>
              <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Toys & Games</a>
                </li>
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Kids Clothing</a>
                </li>
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">School Supplies</a>
                </li>
                <li>
                  <a href="#" class="text-gray-600 hover:text-indigo-500">Children's Books</a>
                </li>
              </ul>
            </li>

          </ul>
        </div>
      </nav>

      <!-- Nav ber for mobile version  -->
      <div class="fixed inset-x-0 bottom-0 bg-white shadow-lg p-2 z-50 flex justify-around items-center sm:hidden">
        <div class="relative">
          <div class="dropdown dropdown-top dropdown-hover">
            <div tabindex="0" role="button" class="btn m-1 btn-ghost">
              <ion-icon name="menu-outline" class="text-2xl"></ion-icon>
            </div>
            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
              <li><a href="../Art/ArtWelcome.php">Art or Craft</a></li>
              <li><a href="#">Second hand Product</a></li>
              <li><a href="#">Electronics</a></li>
              <li><a href="#">Men's Items</a></li>
              <li><a href="#">Women's Items</a></li>
              <li><a href="#">Accessories</a></li>
            </ul>
          </div>
        </div>

        <button onclick="showCartList()" class="btn btn-ghost relative">
          <ion-icon name="bag-handle-outline" class="text-2xl"></ion-icon>
          <!-- <span class="badge badge-sm badge-error absolute -top-1 -right-1">0</span> -->
        </button>

        <button class="btn btn-ghost" onclick="window.location.href = '../HomePage/InitialPage1.php'">
          <ion-icon name="home-outline" class="text-2xl"></ion-icon>
        </button>

        <button onclick="showWishList()" class="btn btn-ghost relative">
          <ion-icon name="heart-outline" class="text-2xl"></ion-icon>
          <!-- <span class="badge badge-sm badge-error absolute -top-1 -right-1">0</span> -->
        </button>

        <button class="btn btn-ghost" data-mobile-menu-open-btn>
          <ion-icon name="grid-outline" class="text-2xl"></ion-icon>
        </button>
      </div>
  </header>
  <!-- This is for voice Search -->
  <script>
    // Select DOM elements
    const searchInput = document.getElementById('searchInput');
    const voiceSearchButton = document.getElementById('voiceSearchButton');

    // Voice search functionality using the Web Speech API
    voiceSearchButton.addEventListener('click', () => {
      const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();

      recognition.lang = 'en-US'; // Language set to English (US)
      recognition.interimResults = false; // Only the final result is considered
      recognition.continuous = false; // Stop after one result

      recognition.start();

      // Event fired when speech recognition starts
      recognition.onstart = () => {
        console.log('Voice recognition started...');
      };

      // Event fired when a result is detected
      recognition.onresult = (event) => {
        const spokenQuery = event.results[0][0].transcript; // Get the spoken query
        console.log('Recognized speech:', spokenQuery);

        // Update the search input with the recognized speech
        searchInput.value = spokenQuery;

        // Perform the search with the spoken input
        handleSearch();
      };

      // Handle errors in speech recognition
      recognition.onerror = (event) => {
        console.error('Voice recognition error:', event.error);
        alert('Voice recognition error: ' + event.error);
      };

      // Event fired when speech recognition ends
      recognition.onend = () => {
        console.log('Voice recognition ended.');
      };
    });

    // Handle search (this can be your existing search logic)
    function handleSearch() {
      const query = searchInput.value.trim();

      if (query === "") {
        alert("Please enter a search term or speak into the microphone.");
        return;
      }

      // Trigger search (for demonstration purposes, logging the query)
      console.log("Searching for:", query);

      // Fetch results (you can adapt this part to integrate with your backend)
      fetch(`search.php?query=${encodeURIComponent(query)}`)
        .then((response) => response.text())
        .then((html) => {
          // Handle the search result
          console.log('Search results:', html);
          // You can replace or update your search results section here
        })
        .catch((error) => {
          console.error('Error fetching search results:', error);
        });
    }
  </script>
  <script>
    function showCartList() {
      // PHP variables passed to JavaScript
      var loggedIn = <?php echo json_encode(isset($_SESSION['loggedin']) && $_SESSION['loggedin']); ?>;
      var userType = <?php echo json_encode($_SESSION['user_type'] ?? ''); ?>;
      var userId = <?php echo json_encode($_SESSION['user_id'] ?? 0); ?>;

      // Check if logged in and user type is 'customer_info'
      if (loggedIn && userType === 'customer_info') {
        // Redirect to Cartlist.php with the user ID
        window.location.href = '../Cart/Cartlist.php?user_id=' + userId;
      } else {
        // Optionally handle the case where user is not logged in or not a customer
        alert('Please log in as a customer to view your cart.');
      }
    }

    function showWishList() {
      // PHP variables passed to JavaScript
      var loggedIn = <?php echo json_encode(isset($_SESSION['loggedin']) && $_SESSION['loggedin']); ?>;
      var userType = <?php echo json_encode($_SESSION['user_type'] ?? ''); ?>;
      var userId = <?php echo json_encode($_SESSION['user_id'] ?? 0); ?>;

      // Check if logged in and user type is 'customer_info'
      if (loggedIn && userType === 'customer_info') {
        // Redirect to Cartlist.php with the user ID
        window.location.href = '../Wishlist/Wishlist.php?user_id=' + userId;
      } else {
        // Optionally handle the case where user is not logged in or not a customer
        alert('Please log in as a customer to view your cart.');
      }
    }
  </script>
  <script>
    function checkEnter(event) {
      if (event.key === 'Enter') {
        handleSearch();
      }
    }

    function handleSearch() {
      // Get the value from the search input field
      const searchValue = document.getElementById('searchInput').value;

      if (searchValue) {
        // Construct the URL with the search term as a query parameter
        var url = '../Auto_Complete/Search.php?search=' + encodeURIComponent(searchValue);

        // Redirect the user to the Search.php page with the search term
        window.location.href = url;
      } else {
        // If the search value is empty, show a modal to prompt the user to enter a search term
        showModal('Please Enter a Search Term', 'You must enter a search term to search.');
      }
    }

    // Modal function to show the alert (for demonstration)
    function showModal(title, message) {
      alert(title + "\n" + message); // Simple alert for now
    }
  </script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../Auto_Complete/AutoComplete.js"></script>

</body>

</html>