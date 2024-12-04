<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Submission Form</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 0.5em;
            display: none;
        }
    </style>
</head>

<body>
    <?php
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ZenithZone";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $message = ''; // To hold success or error message
    $artistId = 7; // This should be fetched based on session or a predefined value

    // Check if artist_id exists in the artist_info table
    $checkArtist = $conn->prepare("SELECT artist_id FROM artist_info WHERE artist_id = ?");
    $checkArtist->bind_param("i", $artistId);
    $checkArtist->execute();
    $checkArtist->store_result();

    if ($checkArtist->num_rows == 0) {
        $message = "Artist ID does not exist. Please check your input.";
        $checkArtist->close();
    } else {
        $checkArtist->close();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $artName = $_POST['artName'];
            $artDescription = $_POST['artDescription'];
            $initialPrice = $_POST['initialPrice'];
            $creationDate = date('Y-m-d H:i:s'); // Current date and time

            // Prepare to insert the art details into the database
            $stmt = $conn->prepare("INSERT INTO art_gallery (artist_id, art_name, art_description, art_init_price, creation_date) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issds", $artistId, $artName, $artDescription, $initialPrice, $creationDate);
            if (!$stmt->execute()) {
                $message = "Error: " . $stmt->error;
            } else {
                $lastId = $stmt->insert_id; // Get the last inserted id to name the image file
                $stmt->close();

                // Handle the image upload
                if ($_FILES['artImage']['error'] == 0) {
                    $targetDirectory = "art_gallery/";
                    $targetFile = $targetDirectory . $lastId . '.jpg';
                    if (move_uploaded_file($_FILES['artImage']['tmp_name'], $targetFile)) {
                        // Update the database with the image file path
                        $stmt = $conn->prepare("UPDATE art_gallery SET art_img = ? WHERE art_id = ?");
                        $stmt->bind_param("si", $targetFile, $lastId);
                        $stmt->execute();
                        $stmt->close();
                        $message = "Art has been submitted successfully.";
                    } else {
                        $message = "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $message = "Error: " . $_FILES['artImage']['error'];
                }
            }
        }
    }

    $conn->close();
    ?>
    <div class="mt-5 mb-5 max-w-4xl mx-auto font-[Poppins] p-6 bg-gray-100 rounded-lg">
        <?php if ($message) echo "<p class='text-center text-green-500'>$message</p>"; ?>
        <form id="artSubmissionForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <h1 class="text-center font-bold text-black text-xl">Art Submission Form</h1>
            <div class="grid sm:grid-cols-1 gap-8">
                <div class="mt-8">
                    <label class="text-gray-800 text-sm block mb-2">Art Name</label>
                    <input id="artName" name="artName" type="text" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter art name">
                </div>
                <div class="mt-8">
                    <label class="text-gray-800 text-sm block mb-2">Art Description</label>
                    <textarea id="artDescription" name="artDescription" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Describe the art" rows="4"></textarea>
                </div>
                <div class="mt-8">
                    <label class="text-gray-800 text-sm block mb-2">Initial Price</label>
                    <input id="initialPrice" name="initialPrice" type="number" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter initial price">
                </div>
                <div class="mt-8">
                    <label class="text-gray-800 text-sm block mb-2">Upload Art Image</label>
                    <input id="artImage" name="artImage" type="file" required class="w-full bg-transparent text-sm text-gray-800 px-2 py-3 outline-none">
                </div>
            </div>
            <div class="flex justify-center mt-12">
                <button type="submit" class="py-3.5 px-7 text-sm font-semibold tracking-wider rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">Submit Art</button>
            </div>
        </form>
    </div>

    <script>
        function validateForm() {
            let artName = document.getElementById('artName').value.trim();
            let artDescription = document.getElementById('artDescription').value.trim();
            let initialPrice = document.getElementById('initialPrice').value.trim();
            let artImage = document.getElementById('artImage').value;

            if (!artName || !artDescription || isNaN(initialPrice) || initialPrice <= 0 || !artImage) {
                alert("Please ensure all fields are filled correctly. Initial price must be a positive number.");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>