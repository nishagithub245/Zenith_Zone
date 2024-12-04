<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenithZone</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">

    <style>
        body,
        h2 {
            font-family: 'Montserrat', sans-serif;
        }

        /* Hide button initially and only show on card hover */
    </style>
</head>

<body class="bg-cover bg-center bg-no-repeat" style="background-image: url('./resources/1537617_4683.jpg');">
    <?php
    include "../Header_Footer/fixed_header.php";
    ?>

    <div class=" container mx-auto mt-40 px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-6">
            <?php
            $query = "SELECT * FROM art_gallery";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $artId = $row['art_id']; // Fetch the art_id from the current row
            ?>
                    <div class="card glass w-72 h-96 mx-auto group relative"> <!-- Added a fixed height of 96 (24rem) -->
                        <figure class="group-hover:blur-sm transition-all duration-300 ease-in-out h-full"> <!-- Ensure the figure takes the full height -->
                            <img src="<?php echo htmlspecialchars($row['art_img']); ?>" alt="Art: <?php echo htmlspecialchars($row['art_name']); ?>" class="w-full h-full object-cover"> <!-- Used object-cover for consistent display -->
                        </figure>
                        <div class="card-actions justify-center">
                            <h2 class="card-title font-bold group-hover:blur-sm transition-all duration-300 ease-in-out">
                                <?php echo htmlspecialchars($row['art_name']); ?>
                            </h2>
                            <!-- Button hidden by default and only visible on hover, centered within the card -->
                            <button
                                onclick="window.location.href='./art_bid.php?artId=<?php echo $artId; ?>';"
                                class="btn btn-outline btn-accent opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out absolute inset-x-0 bottom-1/2 mx-auto 
    bg-gradient-to-r from-teal-400 via-blue-500 to-indigo-600 text-white font-semibold py-3 px-6 rounded-lg shadow-xl 
    transform hover:scale-105 hover:shadow-2xl hover:bg-gradient-to-l from-purple-600 via-pink-500 to-red-600 transition-all ease-in-out">
                                Explore!
                            </button>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo "<p class='text-center'>No art pieces found!</p>";
            }
            ?>
        </div>
    </div>
    <?php
    include "../Header_Footer/footer.php";
    ?>
</body>

</html>