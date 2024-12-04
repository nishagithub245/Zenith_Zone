<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'DB_Connection.php';

$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;

$sql = "SELECT * FROM product_info ORDER BY RAND() LIMIT ?, ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("Error preparing SQL statement: " . $conn->error);
}

$stmt->bind_param("ii", $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
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
      <a href="product_details.php?product_id=' . $row["Product_id"] . '" class="inline-block text-blue-500 hover:text-blue-600 text-sm">' . strtoupper($row["Product_name"]) . '</a>
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
  echo '';
}

$stmt->close();
$conn->close();
