<?php
include "../Database_Connection/DB_Connection.php";

if (isset($_POST['Sh_product_id']) && isset($_POST['action'])) {
    $id = intval($_POST['Sh_product_id']);
    $action = $_POST['action'];

    $approvalStatus = ($action === 'approve') ? 'approved' : 'rejected';

    $query = "UPDATE second_hand_product SET approval_status = ? WHERE Sh_product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $approvalStatus, $id);

    if ($stmt->execute()) {
        echo ucfirst($approvalStatus) . " successfully.";
    } else {
        echo "Failed to update the product status.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
