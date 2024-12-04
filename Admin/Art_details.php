<?php
include "../Database_Connection/DB_Connection.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "SELECT * FROM art_gallery WHERE art_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $art = $result->fetch_assoc();

        // Display art details along with the image
        echo "
            <div>
                <p><strong>Art ID:</strong> " . htmlspecialchars($art['art_id']) . "</p>
                <p><strong>Art Name:</strong> " . htmlspecialchars($art['art_name']) . "</p>
                <p><strong>Description:</strong> " . htmlspecialchars($art['art_description']) . "</p>
                <p><strong>Initial Price:</strong> " . htmlspecialchars($art['art_init_price']) . " BDT</p>
                <p><strong>Creation Date:</strong> " . htmlspecialchars($art['creation_date']) . "</p>
                <div>
                    <strong>Art Image:</strong><br>
                    <img 
                        src='../art_gallery/" . htmlspecialchars($art['art_img']) . "' 
                        alt='Art Image' 
                        class='w-full h-auto max-h-96 mt-4 border rounded'
                    />
                </div>
            </div>

            <!-- Approve / Reject Buttons -->
            <div class='mt-6'>
                <button id='approve-btn' class='bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600'>Approve</button>
                <button id='reject-btn' class='bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 ml-4'>Reject</button>
            </div>

            <!-- Bid End Date Field (Hidden initially) -->
            <div id='date-field' class='hidden mt-6'>
                <label for='bid_end_date' class='block text-sm font-medium text-gray-700'>Set Bid End Date:</label>
                <input 
                    type='datetime-local' 
                    id='bid_end_date' 
                    class='mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm'
                />
                <button id='submit-bid-date' class='mt-4 bg-blue-500 text-white py-2 px-4 rounded'>Submit</button>
            </div>
        ";
    } else {
        echo "Art details not found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let artId = <?php echo $id; ?>;

        // Show the 'Set Bid End Date' input when "Approve" is clicked
        $('#approve-btn').click(function () {
            $('#date-field').removeClass('hidden'); // Show bid end date input
        });

        // Handle "Reject" button click
        $('#reject-btn').click(function () {
            $.ajax({
                url: './UpdateArtStatus.php',
                type: 'POST',
                data: { art_id: artId, action: 'reject' },
                success: function (response) {
                    alert('The Art is Rejected');
                    location.reload(); // Reload the page after rejection
                },
                error: function () {
                    alert('Failed to reject the art.');
                }
            });
        });

        // Handle "Submit Bid End Date" button click
        $('#submit-bid-date').click(function () {
            const bidEndDate = $('#bid_end_date').val();
            if (!bidEndDate) {
                alert('Please set the bid end date.');
                return;
            }

            $.ajax({
                url: './UpdateArtStatus.php',
                type: 'POST',
                data: { art_id: artId, action: 'approve', bid_end_date: bidEndDate },
                success: function (response) {
                    alert('The Art is approved');
                    location.reload(); // Reload the page after approval
                },
                error: function () {
                    alert('Failed to approve the art.');
                }
            });
        });
    });
</script>
