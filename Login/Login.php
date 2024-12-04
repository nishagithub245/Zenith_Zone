<?php
session_start();
include "../Database_Connection/DB_Connection.php";

// Improved error handling with try-catch
try {
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    $login_error = '';
    $login_success = false;
    $first_name = '';
    $found = false;
    $gender = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email_mobile = $_POST['email_mobile'];
        $password = $_POST['password'];

        // Check if the credentials are 0000 for admin
        if ($email_mobile === '0000' && $password === '0000') {
            // Redirect to Admin Dashboard
            header("Location: ../Admin/Admin_dashboard.php");
            exit(); // Stop further script execution
        }
        // Check user credentials across three tables
        $tables = [
            ['name' => 'artist_info', 'id_column' => 'artist_id', 'email_column' => 'email', 'password_column' => 'password_hash', 'first_name_column' => 'first_name', 'gender_column' => 'gender'],
            ['name' => 'customer_info', 'id_column' => 'customer_id', 'email_column' => 'email', 'password_column' => 'password', 'first_name_column' => 'first_name', 'gender_column' => 'gender'],
            ['name' => 'sellersinfo', 'id_column' => 'seller_id', 'email_column' => 'email', 'password_column' => 'password_hash', 'first_name_column' => 'first_name', 'gender_column' => 'gender']
        ];

        foreach ($tables as $table) {
            $query = "SELECT {$table['id_column']}, {$table['password_column']}, {$table['first_name_column']}, {$table['gender_column']} FROM {$table['name']} WHERE {$table['email_column']} = ? OR mobile_number = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception('MySQL prepare error: ' . $conn->error);
            }
            $stmt->bind_param("ss", $email_mobile, $email_mobile);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user[$table['password_column']])) {
                    $found = true;
                    $login_success = true;
                    $first_name = $user[$table['first_name_column']];
                    $gender = $user[$table['gender_column']];  // Set gender here
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email_mobile'] = $email_mobile;
                    $_SESSION['user_id'] = $user[$table['id_column']];
                    $_SESSION['user_type'] = $table['name'];
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['gender'] = $gender;  // Store gender in session

                    break;
                }
            }
            $stmt->close();
        }

        if (!$found) {
            $login_error = "Invalid credentials!";
        }
    }

    $conn->close();
} catch (Exception $e) {
    $login_error = $e->getMessage();  // Set login_error to the exception message
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZenithZone - eCommerce Website</title>

    <!--
    - favicon
  -->
    <link rel="shortcut icon" href="../assets/images/logo/ZentihZone.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css?family=Varela&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet" />
    <!-- Login css link -->
    <link rel="stylesheet" href="./LoginStyle.css">
</head>

<body>
    <div id="particles-js"></div>

    <div class="login-box">
        <div class="flex justify-center mb-1">
            <img src="../assets/images/logo/ZenithZone.png" alt="ZenithZone logo" class="w-20" />
        </div>
        <h2 class="text-white text-2xl text-center">Welcome to ZenithZone</h2>
        <form method="POST">
            <div class="user-box">
                <input type="text" name="email_mobile" required />
                <label>Email/Mobile no.</label>
            </div>
            <div class="user-box">
                <input type="password" id="password" name="password" required />
                <svg onclick="togglePasswordVisibility('password', this)" xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-6 h-6 absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer" viewBox="0 0 128 128">
                    <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
                </svg>
                <label>Password</label>
            </div>
            <div class="flex justify-center mb-3">
                <button type="submit" class="btn">Login</button>
            </div>
            <div class="flex justify-between items-center mb-4">
            <a href="#" class="text-white text-sm font-bold hover:underline text-stroke">Forgot your password?</a>
            </div>
            <p class="text-white text-center">
                Don't have an account?
                <a href="../Registration/Who.php" class="text-teal-400 hover:underline text-blue-400 font-bold">Sign up now</a>

            </p>
        </form>
    </div>

    <!-- Success Modal -->
    <dialog id="successModal" class="bg-white rounded-lg p-5 shadow text-center">
        <h3 class="text-lg font-bold flex justify-center items-center gap-2">
            <i class="fa-solid fa-circle-check" style="color: #3feeba;"></i> Login Successful!
        </h3>
        <p class="mt-2">Hi <?php echo htmlspecialchars($first_name); ?>, welcome to ZenithZone.</p>
        <div class="flex justify-center mt-4">
            <!-- Proceed Button with user_type, user_id, and gender from session -->
            <button onclick="window.location='../HomePage/Personalized_products.php?gender=<?php echo $_SESSION['gender']; ?>';" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Proceed</button>
        </div>
    </dialog>

    <!-- Error Modal -->
    <dialog id="errorModal" class="bg-white rounded-lg p-5 shadow text-center">
        <h3 class="text-lg font-bold flex justify-center items-center gap-2">
            <i class="fa-solid fa-circle-xmark" style="color: #ff4b0f;"></i> Login Error
        </h3>
        <p id="errorText"></p>
        <div class="flex justify-center mt-4">
            <button onclick="this.parentNode.parentNode.close();" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Close</button>
        </div>
    </dialog>


    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="./LoginScript.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginSuccess = <?php echo json_encode($login_success); ?>;
            const loginError = <?php echo json_encode($login_error); ?>;
            if (loginError) {
                document.getElementById('errorText').innerText = loginError;
                const errorModal = document.getElementById('errorModal');
                console.log(errorModal); // Log to check if the modal is selected correctly
                if (errorModal) {
                    errorModal.showModal();
                }
            }
            if (loginSuccess) {
                document.getElementById('successModal').showModal();

                // Send AJAX request to fixed_header.php
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "../Header_Footer/fixed_header.php", true);
                // xhr.open("POST", "../Products/Product_view.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                // Prepare the data to send
                const data = `loggedin=${encodeURIComponent(<?php echo json_encode($_SESSION['loggedin']); ?>)}&user_type=${encodeURIComponent(<?php echo json_encode($_SESSION['user_type']); ?>)}&user_id=${encodeURIComponent(<?php echo json_encode($_SESSION['user_id']); ?>)}`;

                // Send the data
                xhr.send(data);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        console.log("Data sent successfully to fixed_header.php");
                    }
                };
            }
        });
    </script>
</body>

</html>