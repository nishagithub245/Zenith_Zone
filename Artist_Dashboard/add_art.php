<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Art</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
            <h1 class="text-2xl font-bold mb-6">Add New Art</h1>
            <form action="submit_art.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <!-- Art Name -->
                <div>
                    <label for="art_name" class="block text-gray-600 font-semibold mb-2">Art Name</label>
                    <input type="text" id="art_name" name="art_name" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter art name" required>
                </div>

                <!-- Art Description -->
                <div>
                    <label for="art_description" class="block text-gray-600 font-semibold mb-2">Description</label>
                    <textarea id="art_description" name="art_description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter art description" required></textarea>
                </div>

                <!-- Art Image -->
                <div>
                    <label for="art_img" class="block text-gray-600 font-semibold mb-2">Upload Image</label>
                    <input type="file" id="art_img" name="art_img" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <!-- Art Initial Price -->
                <div>
                    <label for="art_init_price" class="block text-gray-600 font-semibold mb-2">Initial Price (in BDT)</label>
                    <input type="number" id="art_init_price" name="art_init_price" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter initial price" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-300">
                    Add Art
                </button>
            </form>

            <!-- Success/Error Messages -->
            <?php if (isset($_GET['status'])): ?>
                <?php if ($_GET['status'] == 'success'): ?>
                    <p class="mt-4 text-green-600">Art added successfully!</p>
                <?php elseif ($_GET['status'] == 'error'): ?>
                    <p class="mt-4 text-red-600">Error: Could not add art. Please try again.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
