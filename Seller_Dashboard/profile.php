<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen">
    <!-- Include Fixed Header -->
    <div class="flex">
              <div class="container mx-auto p-6 flex-1">
    <?php
    session_start(); // Start the session to access session variables
    
    // Get seller_id from session
    $seller_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    // Database connection
    if ($seller_id) {
      // Database connection
      include "../Database_Connection/DB_Connection.php";
  
      // Fetch seller data
      $sql = "SELECT * FROM sellersinfo WHERE seller_id = $seller_id";
      $result = $conn->query($sql);
  
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
      }
  ?>
      <!-- Profile Overview -->
      <div class="profile-overview mb-8">
        <h1 class="text-2xl font-bold mb-4 text-center">My Profile</h1>
        <!-- Center the profile picture -->
        <div class="flex justify-center mt-32 mb-6">
                <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-blue-500">
                <img src="../Registration/<?= htmlspecialchars($row['seller_picture'] ?? '/path/to/default-avatar.png') ?>" 
     alt="Profile Picture" class="w-full h-full object-cover">
                </div>
            </div>
      </div>

      <!-- Non-editable Profile Form -->
      <form method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-4 rounded-lg shadow-md max-w-2xl mx-auto">
        <!-- First and Last Name (Single Row) -->
        <div class="grid grid-cols-2 gap-4">
          <!-- First Name -->
          <div>
            <label for="first_name" class="text-gray-800 text-sm block mb-2">First Name</label>
            <input id="first_name" name="first_name" type="text" value="<?php echo htmlspecialchars($row['first_name']); ?>"
                   class="w-full bg-gray-100 text-base font-semibold text-gray-800 px-4 py-2 rounded-lg border border-gray-300 outline-none" 
                   readonly />
          </div>

          <!-- Last Name -->
          <div>
            <label for="last_name" class="text-gray-800 text-sm block mb-2">Last Name</label>
            <input id="last_name" name="last_name" type="text" value="<?php echo htmlspecialchars($row['last_name']); ?>"
                   class="w-full bg-gray-100 text-base font-semibold text-gray-800 px-4 py-2 rounded-lg border border-gray-300 outline-none" 
                   readonly />
          </div>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="text-gray-800 text-sm block mb-2">Email</label>
          <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($row['email']); ?>"
                 class="w-full bg-gray-100 text-base font-semibold text-gray-800 px-4 py-2 rounded-lg border border-gray-300 outline-none" 
                 readonly />
        </div>

        <!-- Mobile Number -->
        <div>
          <label for="mobile_number" class="text-gray-800 text-sm block mb-2">Mobile Number</label>
          <input id="mobile_number" name="mobile_number" type="tel" value="<?php echo htmlspecialchars($row['mobile_number']); ?>"
                 class="w-full bg-gray-100 text-base font-semibold text-gray-800 px-4 py-2 rounded-lg border border-gray-300 outline-none" 
                 readonly />
        </div>

        <!-- Address -->
        <div>
          <label for="address" class="text-gray-800 text-sm block mb-2">Address</label>
          <input id="address" name="address" type="text" value="<?php echo htmlspecialchars($row['address']); ?>"
                 class="w-full bg-gray-100 text-base font-semibold text-gray-800 px-4 py-2 rounded-lg border border-gray-300 outline-none" 
                 readonly />
        </div>

  
        <!-- Date of Birth -->
        <div>
          <label for="date_of_birth" class="text-gray-800 text-sm block mb-2">Date of Birth</label>
          <input id="date_of_birth" name="date_of_birth" type="date" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>"
                 class="w-full bg-gray-100 text-base font-semibold text-gray-800 px-4 py-2 rounded-lg border border-gray-300 outline-none" 
                 readonly />
        </div>

        <!-- Gender -->
        <div>
          <label for="gender" class="text-gray-800 text-sm block mb-2">Gender</label>
          <input id="gender" name="gender" type="text" value="<?php echo htmlspecialchars($row['gender']); ?>"
                 class="w-full bg-gray-100 text-base font-semibold text-gray-800 px-4 py-2 rounded-lg border border-gray-300 outline-none" 
                 readonly />
        </div>

        <!-- NID Number -->
        <div>
          <label for="nid_number" class="text-gray-800 text-sm block mb-2">NID Number</label>
          <input id="nid_number" name="nid_number" type="text" value="<?php echo htmlspecialchars($row['nid_number']); ?>"
                 class="w-full bg-gray-100 text-base font-semibold text-gray-800 px-4 py-2 rounded-lg border border-gray-300 outline-none" 
                 readonly />
        </div>
      </form>
    <?php
    } else {
        echo "<p class='text-red-500'>No seller information found!</p>";
    }
    $conn->close();
    ?>
  </div>
</body>
</html>
