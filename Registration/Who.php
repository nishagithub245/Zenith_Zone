<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ZentihZone</title>
  <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    /* Custom CSS for unique skew and hover animations */
    .form-entrance {
      transform: skewY(-5deg);
      transition: transform 0.3s cubic-bezier(0.075, 0.82, 0.165, 1),
        box-shadow 0.3s cubic-bezier(0.075, 0.82, 0.165, 1);
    }

    .form-entrance:hover {
      transform: skewY(0deg) scale(1.01);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="">
  <?php
  include "../Header_Footer/fixed_header.php";
  ?>

  <div class="w-full h-screen flex items-center justify-center mt-16">
    <div class="py-10 px-4 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold mb-8 text-center text-indigo-500">
        I am a ...
      </h1>
      <div class="flex justify-center">
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-6">
          <!-- Customer Card -->
          <div class="bg-white shadow-lg rounded-lg overflow-hidden relative group hover:border-green-500 hover:border-2 transition duration-300 w-48">
            <a href="./customerreg.php" class="">
              <img src="../assets/images/logo/customer.svg" alt="Customer" class="w-full object-scale-down h-48 transition duration-300 ease-in-out" />
              <div class="text-center py-2 font-semibold">Customer</div>
            </a>
          </div>

          <!-- Seller Card -->
          <div class="bg-white shadow-lg rounded-lg overflow-hidden relative group hover:border-green-500 hover:border-2 transition duration-300 w-48">
            <a href="./sellereg.php" class="">
              <img src="../assets/images/logo/Seller.png" alt="Seller" class="w-full object-scale-down h-48 transition duration-300 ease-in-out" />
              <div class="text-center py-2 font-semibold">Seller</div>
            </a>
          </div>

          <!-- Artist Card -->
          <div class="bg-white shadow-lg rounded-lg overflow-hidden relative group hover:border-green-500 hover:border-2 transition duration-300 w-48">
            <a href="./artistreg.php" class="">
              <img src="../assets/images/logo/Artist.svg" alt="Artist" class="w-full object-scale-down h-48 transition duration-300 ease-in-out" />
              <div class="text-center py-2 font-semibold">Artist</div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--
    - FOOTER
  -->
  <?php
  include "../Header_Footer/footer.php";
  ?>
  <!--
  - ionicon link
-->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>