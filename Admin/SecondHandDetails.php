<?php
include "../Database_Connection/DB_Connection.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare the query to fetch product details
    $query = "SELECT * FROM second_hand_product WHERE Sh_product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Safely construct the image path
        $image_path = "../S_products/" . htmlspecialchars($product['Sh_image_path']);
        
        // Debugging for image path
        if (!file_exists($image_path)) {
            echo "<p style='color: red;'>Image not found at: $image_path</p>";
        }

        // Display the product details along with the buttons below it
        echo "
            <div style='width: 80%; max-width: 800px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); margin: 0 auto;'>
                <h2 class='text-center mb-4'>Product Details</h2>
                <p><strong>Product ID:</strong> " . htmlspecialchars($product['Sh_product_id']) . "</p>
                <p><strong>Product Name:</strong> " . htmlspecialchars($product['Sh_product_name']) . "</p>
                <p><strong>Category:</strong> " . htmlspecialchars($product['Sh_category']) . "</p>
                <p><strong>Price:</strong> " . htmlspecialchars($product['Sh_price']) . " BDT</p>
                <p><strong>Date Posted:</strong> " . htmlspecialchars($product['Sh_date_posted']) . "</p>
                <p><strong>Description:</strong> " . htmlspecialchars($product['Sh_Product_description']) . "</p>
                <div class='text-center'>
                    <strong>Product Image:</strong><br>
                    <img 
                        src='" . $image_path . "' 
                        alt='Product Image' 
                        class='w-64 h-auto mt-4 border rounded'
                    />
                </div>
                <!-- Approve and Reject buttons placed below the product details -->
                <div class='text-center mt-4'>
                    <button id='approve-btn' data-id='" . $product['Sh_product_id'] . "' class='bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600'>Approve</button>
                    <button id='reject-btn' data-id='" . $product['Sh_product_id'] . "' class='bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600'>Reject</button>
                </div>
            </div>
        ";
    } else {
        echo "<p style='color: red;'>Product details not found.</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<p style='color: red;'>Invalid request.</p>";
}
?>
<script>
    $(document).ready(function () {
    $('.view-btn').click(function () {
        let productId = $(this).data('id');  // Get the productId from the button's data-id attribute
        
        $.ajax({
            url: './SecondHandDetails.php',
            type: 'GET',
            data: { id: productId },
            success: function (data) {
                $('#modal-body').html(data); // Load the product details into the modal
            },
            error: function () {
                alert('Failed to fetch product details.');
            }
        });
    });

    // Approve button click
    $(document).on('click', '#approve-btn', function () {
        let productId = $(this).data('id'); // Get productId from the button's data-id

        $.ajax({
            url: './Update_secondhand_status.php',
            type: 'POST',
            data: { Sh_product_id: productId, action: 'approve' },
            success: function (response) {
                alert(response);
                location.reload();
            },
            error: function () {
                alert('Failed to approve the product.');
            }
        });
    });

    // Reject button click
    $(document).on('click', '#reject-btn', function () {
        let productId = $(this).data('id'); // Get productId from the button's data-id

        $.ajax({
            url: './Update_secondhand_status.php',
            type: 'POST',
            data: { Sh_product_id: productId, action: 'reject' },
            success: function (response) {
                alert(response);
                location.reload();
            },
            error: function () {
                alert('Failed to reject the product.');
            }
        });
    });
});
</script>