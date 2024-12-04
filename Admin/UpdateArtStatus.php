<?php
include "../Database_Connection/DB_Connection.php";

if (isset($_POST['art_id']) && isset($_POST['action'])) {
    $id = intval($_POST['art_id']);
    $action = $_POST['action'];
    $approvalStatus = ($action === 'approve') ? 'approved' : 'rejected';

    // Debug: Output POST data
    var_dump($_POST);

    if ($action === 'approve' && isset($_POST['bid_end_date'])) {
        $bidEndDate = $_POST['bid_end_date'];

        // Debug: Output bid end date
        echo "Bid End Date: " . $bidEndDate;

        $query = "UPDATE art_gallery SET approval_status = ?, bid_end_date = ? WHERE art_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $approvalStatus, $bidEndDate, $id);

        if ($stmt->execute()) {
            echo "Art approved successfully. Bid end date set.";
        } else {
            // echo "Failed to update the art status.";
        }

        $stmt->close();
    } elseif ($action === 'reject') {
        $query = "UPDATE art_gallery SET approval_status = ? WHERE art_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $approvalStatus, $id);

        if ($stmt->execute()) {
            echo "Art rejected successfully.";
        } else {
            // echo "Failed to update the art status.";
        }

        $stmt->close();
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
