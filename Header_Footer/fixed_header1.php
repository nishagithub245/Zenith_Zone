<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: ../Login/Login.php");
  exit;
}

// Check if the first_name session variable is set and assign it or use 'User' as a default
$first_name = $_SESSION['first_name'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ZenithZone</title>
  <link rel="stylesheet" href="../Auto_Complete/AutoComplete.css"> <!-- Include your CSS here -->
</head>

<body>
  <?php include '../Auto_Complete/AutoComplete.php'; ?>

  <header>
    <!-- First navigation bar -->
    <div class="fixed top-0 left-0 right-0 z-50 group">
      <!-- Animated gradient background with hover effect -->
      <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-violet-600 rounded-lg blur opacity-25 transition-opacity duration-1000 group-hover:opacity-100"></div>

      <!-- Navigation content -->
      <div class="relative bg-[#363b41] py-5 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col sm:flex-row justify-between items-center">
            <!-- Logo -->
            <a href="../HomePage/InitialPage1.php" class="flex-shrink-0">
              <img src="../assets/images/logo/ZenithZone.png" alt="ZenithZone logo" class="h-16 sm:h-20" />
            </a>

            <!-- Search Field for Large Devices -->
            <div class="flex-grow mx-10 my-2 sm:my-0 hidden md:block">
              <div class="relative">
                <input type="search" id="searchInput" name="search" class="input-field w-full pl-4 pr-20 py-2 border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border rounded-md" placeholder="Enter your product name..." />
                <!-- Autocomplete Suggestions Box -->
                <ul id="searchSuggestions" class="autobox absolute z-10 bg-white w-full shadow-lg max-h-60 overflow-y-auto"></ul>
                <!-- Search and Voice Buttons -->
                <button class="absolute inset-y-0 right-10 px-3 flex items-center">
                  <ion-icon name="search-outline" class="h-5 w-5 text-gray-500"></ion-icon>
                </button>
                <button class="absolute inset-y-0 right-0 px-3 flex items-center">
                  <ion-icon name="mic-outline" class="h-5 w-5 text-gray-500"></ion-icon>
                </button>
              </div>
            </div>

            <!-- User Actions and Authentication Links -->
            <div class="flex items-center space-x-4 mt-2 sm:mt-0">
              <?php if ($logged_in): ?>
                <a href="../HomePage/InitialPage1.php" class="text-[#fbad62] hover:text-white transition duration-150 ease-in-out">Logout</a>
                <a href="#" class="text-[#fbad62] hover:text-white transition duration-150 ease-in-out"><?php echo htmlspecialchars($first_name); ?></a>
              <?php else: ?>
                <a href="../Login/Login.php" class="text-[#fbad62] hover:text-white transition duration-150 ease-in-out">Login</a>
                <a href="../Registration/Who.php" class="text-[#fbad62] hover:text-white transition duration-150 ease-in-out">Signup</a>
              <?php endif; ?>
              <!-- User Action Buttons -->
              <button class="text-[#fbad62] hover:text-white">
                <ion-icon name="person-outline" class="h-6 w-6"></ion-icon>
              </button>
              <button class="relative text-[#fbad62] hover:text-white">
                <ion-icon name="heart-outline" class="h-6 w-6"></ion-icon>
                <span class="absolute -top-2 -right-2 rounded-full bg-red-500 text-white text-xs px-2 py-1">0</span>
              </button>
              <button class="relative text-[#fbad62] hover:text-white">
                <ion-icon name="bag-handle-outline" class="h-6 w-6"></ion-icon>
                <span class="absolute -top-2 -right-2 rounded-full bg-red-500 text-white text-xs px-2 py-1">0</span>
              </button>
            </div>

            <!-- Search Field for Small Devices -->
            <div class="flex-grow mx-10 my-2 sm:my-0 block sm:hidden">
              <div class="relative">
                <input type="search" id="searchInputMobile" name="search" class="input-field w-full pl-4 pr-20 py-2 border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border rounded-md" placeholder="Enter your product name..." />
                <ul id="searchSuggestionsMobile" class="autobox absolute z-10 bg-white w-full shadow-lg max-h-60 overflow-y-auto"></ul>
                <button class="absolute inset-y-0 right-10 px-3 flex items-center">
                  <ion-icon name="search-outline" class="h-5 w-5 text-gray-500"></ion-icon>
                </button>
                <button class="absolute inset-y-0 right-0 px-3 flex items-center">
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
              <a href="../HomePage/InitialPage1.php" class="text-slate-50 font-bold hover:text-indigo-500">Home</a>
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

        <button class="btn btn-ghost relative">
          <ion-icon name="bag-handle-outline" class="text-2xl"></ion-icon>
          <span class="badge badge-sm badge-error absolute -top-1 -right-1">0</span>
        </button>

        <button class="btn btn-ghost" onclick="window.location.href = '../HomePage/InitialPage1.php'">
          <ion-icon name="home-outline" class="text-2xl"></ion-icon>
        </button>

        <button class="btn btn-ghost relative">
          <ion-icon name="heart-outline" class="text-2xl"></ion-icon>
          <span class="badge badge-sm badge-error absolute -top-1 -right-1">0</span>
        </button>

        <button class="btn btn-ghost" data-mobile-menu-open-btn>
          <ion-icon name="grid-outline" class="text-2xl"></ion-icon>
        </button>
      </div>
    </div>
  </header>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../Auto_Complete/AutoComplete.js"></script>
</body>

</html>