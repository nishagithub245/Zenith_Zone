
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ZenithZone - eCommerce Website</title>

  <!-- favicon -->
  <link rel="shortcut icon" href="../assets/images/logo/ZentihZone.png" type="image/x-icon">

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Custom css link -->
  <link rel="stylesheet" href="./backgorund.css">
</head>

<body>
  <!-- This is for Background -->

    <?php
    include'../Header_Footer/fixed_header.php';
    ?>

<main>
    <?php include 'banner.php'; ?>

    <?php
    include '../Database_Connection/DB_Connection.php';
    if ($conn === null) {
      die("Connection failed: Unable to connect to database");
    }

    $start = 0;
    $limit = 20;

    // Change to fetch data from second_hand_product table
    $sql = "SELECT * FROM second_hand_product WHERE approval_status = 'approved' AND Sh_product_status = 'Available' LIMIT $start, $limit";
    $result = $conn->query($sql);

    echo '<div class="container mx-auto px-4">
      <div class="flex flex-col">
        <div class="text-center py-6">
          <h2 class="text-3xl font-bold text-gray-800 mb-6">Second Hand Products</h2>
          <div id="productGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">';

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<div class="bg-white shadow-lg rounded-lg overflow-hidden relative group hover:border-red-500 hover:border-2 transition duration-300 w-48">
          <a href="./Product_view.php?product_id=' . $row["Sh_product_id"] . '">
              <img src="' . $row["Sh_image_path"] . '" alt="' . htmlspecialchars($row["Sh_product_name"]) . '" class="w-full h-32 object-cover transition duration-300 ease-in-out">
          </a>
          <div class="absolute inset-y-0 right-0 flex flex-col items-center justify-center gap-2 transform translate-x-full transition-transform duration-300 ease-in-out group-hover:translate-x-0 bg-black bg-opacity-0 p-2">
            <button class="text-blue-500 text-md p-0.5 rounded"><i class="far fa-heart"></i></button>
            <a href="./Product_view.php?product_id=' . $row["Sh_product_id"] . '" class="text-blue-500 text-md p-0.5 rounded inline-block">
              <i class="far fa-eye"></i>
            </a>
            <button class="text-blue-500 text-md p-0.5 rounded"><i class="fas fa-shopping-bag"></i></button>
          </div>
          <div class="p-2 text-center">
            <a href="product_details.php?product_id=' . $row["Sh_product_id"] . '" class="block text-blue-500 hover:text-blue-600 text-lg font-semibold" style="font-family: \'Arial\', sans-serif; font-size: 1rem;">' . strtoupper($row["Sh_product_name"]) . '</a>
            <div class="flex justify-center items-baseline space-x-1 mt-2 font-bold">
              <p class="text-lg text-blue-500">৳' . $row["Sh_price"] . '</p>
            </div>
          </div>
        </div>';


      }
    } else {
      echo "<p>No second-hand products found</p>";
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


  <!--
    - FOOTER
  -->
  <?php
  include"../Header_Footer/footer.php";
  ?>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!--
    - custom js link
  -->
  <script src="./auto.js"></script>
  <script src="./background.js"></script>

  <!--
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>