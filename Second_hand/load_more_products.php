<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../Database_Connection/DB_Connection.php';

$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;

// Change the table name and adjust the fields accordingly
$sql = "SELECT * FROM second_hand_product LIMIT ?, ?";
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
    <a href="../Products/Product_view.php?product_id=' . $row["Sh_product_id"] . '">
        <img src="' . $row["Sh_image_path"] . '" alt="' . htmlspecialchars($row["Sh_product_name"]) . '" class="w-full h-32 object-cover transition duration-300 ease-in-out">
    </a>
    <div class="absolute inset-y-0 right-0 flex flex-col items-center justify-center gap-2 transform translate-x-full transition-transform duration-300 ease-in-out group-hover:translate-x-0 bg-black bg-opacity-0 p-2">
      <button class="text-blue-500 text-md p-0.5 rounded"><i class="far fa-heart"></i></button>
      <a href="../Products/Product_view.php?product_id=' . $row["Sh_product_id"] . '" class="text-blue-500 text-md p-0.5 rounded inline-block">
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

$stmt->close();
$conn->close();
?>
