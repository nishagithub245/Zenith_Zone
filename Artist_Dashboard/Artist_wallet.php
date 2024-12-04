<?php
session_start();
include "../Database_Connection/DB_Connection.php";

$artistId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Retrieve artist ID from session
$errorMsg = '';
$walletDetails = null;

if ($artistId) {

    $walletQuery = "
    SELECT wallet_id, balance, created_at 
    FROM artist_wallet
    WHERE artist_id = ? 
    ";

    if ($stmt = $conn->prepare($walletQuery)) {
        $stmt->bind_param("i", $artistId); // Bind the artist_id to the query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the wallet details
            $walletDetails = $result->fetch_assoc();
        } else {
            // No wallet found, so create a new one
            $createWalletQuery = "
            INSERT INTO artist_wallet (artist_id, balance) 
            VALUES (?, 0.00)"; // Initialize balance as 0.00

            if ($stmtCreate = $conn->prepare($createWalletQuery)) {
                $stmtCreate->bind_param("i", $artistId); // Bind the artist_id to the query
                if ($stmtCreate->execute()) {
                    // New wallet created successfully, fetch the new wallet details
                    $walletDetails = [
                        'wallet_id' => $conn->insert_id,
                        'balance' => 0.00,
                        'created_at' => date("Y-m-d H:i:s") // Use current timestamp for created_at
                    ];
                } else {
                    $errorMsg = "Error creating wallet: " . $conn->error;
                }
                $stmtCreate->close();
            } else {
                $errorMsg = "Error preparing wallet creation query: " . $conn->error;
            }
        }

        $stmt->close();
    } else {
        $errorMsg = "Error preparing the query: " . $conn->error;
    }
} else {
    $errorMsg = "Artist not logged in.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Wallet</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is loaded -->
    <style>
        /* Animation for the wallet icon */
        .wallet-icon {
            font-size: 4rem;
            /* Make icon larger */
            transition: transform 0.3s ease-in-out;
        }

        .wallet-icon:hover {
            transform: scale(1.2) rotate(10deg);
            /* Enlarge and slightly rotate on hover */
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Wallet details -->
        <?php if (!empty($walletDetails)) { ?>
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm mx-auto">
                <!-- Wallet icon above the "Your Wallet" title -->
                <div class="text-center mb-4">
                    <i class="fas fa-wallet text-blue-600 wallet-icon"></i> <!-- Animated Wallet Icon -->
                </div>

                <h2 class="text-2xl font-bold mb-4 text-center">
                    Your Wallet
                </h2>
                <div class="flex flex-col items-center">
                    <div class="text-lg font-medium text-gray-900 mb-2">Balance</div>
                    <div class="text-3xl text-green-600 mb-4">৳<?php echo number_format($walletDetails['balance'], 2); ?></div>
                </div>

                <!-- Only show Add Funds button if wallet is not newly created -->
                <div class="mt-6 text-center" id="addFund" >
                    <a class="btn btn-sm btn-primary">Withdraw Money</a>
                </div>
            </div>
        <?php } else { ?>
            <p class="text-center text-red-500"><?php echo $errorMsg; ?></p>
        <?php } ?>
    </div>
    <script>
        $(document).ready(function() {
            $('#addFund').click(function() {
                $.ajax({
                    url: 'add_funds_frontend.php',  // The file that contains the edit form
                    type: 'GET',
                    success: function(response) {
                        $('#content').html(response);  // Assuming there is a div with id 'content' in your dashboard to display content
                    },
                    error: function() {
                        alert('Error loading the edit profile form');
                    }
                });
            });
        });
    </script>
</body>

</html>
