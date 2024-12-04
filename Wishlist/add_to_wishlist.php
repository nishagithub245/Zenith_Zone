<?php
session_start();
require "../Database_Connection/DB_Connection.php";

if (!$conn instanceof mysqli) {
    die('Database connection error: ' . $conn->connect_error);
}

if (!isset($_SESSION['user_type']) || !isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "User not logged in. Redirecting to login page...";
    header("Location: ../Login/Login.php");
    exit();
}

$userType = $_SESSION['user_type'];
$userId = $_SESSION['user_id'];
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if ($userType !== 'customer_info') {
    $_SESSION['message'] = "Access denied. Only customers can add products to the Wishlist.";
    exit;
}

$conn->autocommit(FALSE);

try {
    $stmt = $conn->prepare("SELECT wishlist_id FROM wishlist WHERE customer_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartRow = $result->fetch_assoc();
    $cartId = $cartRow['wishlist_id'] ?? null;

    if (!$cartId) {
        $stmt = $conn->prepare("INSERT INTO wishlist (customer_id) VALUES (?)");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $cartId = $conn->insert_id;
    }

    $stmt = $conn->prepare("SELECT * FROM wishlist_items WHERE wishlist_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $cartId, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->fetch_assoc();

    if (!$exists) {
        $stmt = $conn->prepare("INSERT INTO wishlist_items (wishlist_id, product_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $cartId, $product_id);
        $stmt->execute();
        $_SESSION['message'] = "Product successfully added to your Wishlist.";
    } else {
        $_SESSION['message'] = "Product already exists in your Wishlist.";
    }

    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['message'] = "Error adding product to Wishlist: " . $e->getMessage();
} finally {
    $conn->autocommit(TRUE);
}
// Note: No redirection here, leaving that to the client-side JavaScript.
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenithZone</title>
    <link rel="shortcut icon" href="./assets/images/logo/ZentihZone.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Modal HTML -->
    <div id="messageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-5 shadow text-center">
            <i class="fa-solid fa-circle-check fa-5x" style="color: #3feeba;"></i>
            <h3 class="text-lg font-bold mt-4">Notice</h3>
            <p id="modalMessage" class="mt-2"><?php echo $_SESSION['message'] ?? 'No message'; ?></p>
            <button onclick="hideModal()" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Close</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const message = "<?php echo $_SESSION['message'] ?? ''; ?>";

            if (message) {
                document.getElementById('modalMessage').textContent = message;
                showModal();
                setTimeout(function() {
                    hideModal();
                    // Redirect to the referer page or a default one after 1 second
                    window.location.href = document.referrer || '../DefaultPage.php';
                }, 1500);
            }

            function showModal() {
                document.getElementById('messageModal').classList.remove('hidden');
            }

            function hideModal() {
                document.getElementById('messageModal').classList.add('hidden');
            }
        });
    </script>
</body>

</html>