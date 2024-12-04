<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <style>
        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 0.5em;
            display: none;
        }

        .hidden {
            display: none;
        }

        .visible {
            display: block;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ZenithZone";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email_error = $number_error = '';
    $registration_success = false;
    $error_message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && $_POST['otpVerified'] === "true") {
        $first_name = $_POST['fname'];
        $last_name = $_POST['lname'];
        $email = $_POST['email'];
        $mobile_number = $_POST['number'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("SELECT email, mobile_number FROM customer_info WHERE email = ? OR mobile_number = ?");
        $stmt->bind_param("ss", $email, $mobile_number);
        $stmt->execute();
        $stmt->bind_result($dbEmail, $dbMobileNumber);
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                if ($email == $dbEmail) {
                    $email_error = "Email already registered. Please try another.";
                }
                if ($mobile_number == $dbMobileNumber) {
                    $number_error = "Mobile number already registered. Please try another.";
                }
            }
        } else {
            $insert = $conn->prepare("INSERT INTO customer_info (first_name, last_name, email, mobile_number, password) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("sssss", $first_name, $last_name, $email, $mobile_number, $password);
            if ($insert->execute()) {
                $registration_success = true;
            }
            $insert->close();
        }

        $stmt->close();
    } else {
        $error_message = "OTP verification failed. Please verify your OTP before submitting the form.";
    }

    $conn->close();

    if ($registration_success) {
        echo '<dialog id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">';
        echo '<div class="bg-white rounded-lg p-5 shadow text-center">';
        echo '<h3 class="text-lg font-bold mt-4">Registration Successful!</h3>';
        echo '<p class="mt-2 text-green-700">You have successfully registered.</p>';
        echo '<button onclick="window.location=\'../HomePage/InitialPage.php\';" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Close</button>';
        echo '</div>';
        echo '</dialog>';
        echo "<script>document.getElementById('successModal').showModal();</script>";
    } elseif (!empty($email_error) || !empty($number_error)) {
        $error_message = !empty($email_error) ? $email_error : $number_error;
        echo '<dialog id="errorModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">';
        echo '<div class="bg-white rounded-lg p-5 shadow text-center">';
        echo '<h3 class="text-lg font-bold text-red-700 mt-4">Registration Error</h3>';
        echo "<p class='mt-2'>$error_message</p>";
        echo '<button onclick="window.location=\'./customerreg.php\';" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Close</button>';
        echo '</div>';
        echo '</dialog>';
        echo "<script>document.getElementById('errorModal').showModal();</script>";
    }
    ?>

    <div class="mt-5 mb-5 max-w-4xl mx-auto font-[sans-serif] p-6 bg-gray-100 rounded-lg">
        <form id="signupForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h1 class="text-center font-bold text-black text-xl">Create your ZenithZone Account</h1>
            <div class="grid sm:grid-cols-2 gap-8 mt-8">
                <div>
                    <label class="text-gray-800 text-xs block mb-2">First Name</label>
                    <input id="fname" name="fname" type="text" required class="w-full bg-transparent text-sm border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter first name">
                </div>
                <div>
                    <label class="text-gray-800 text-xs block mb-2">Last Name</label>
                    <input id="lname" name="lname" type="text" required class="w-full bg-transparent text-sm border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter last name">
                </div>
                <div>
                    <label class="text-gray-800 text-xs block mb-2">Email Id</label>
                    <input id="email" name="email" type="email" required class="w-full bg-transparent text-sm border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter email">
                </div>
                <div>
                    <label class="text-gray-800 text-sm block mb-2">Mobile No.</label>
                    <div class="relative">
                        <input id="number" name="number" type="text" required class="w-full bg-transparent text-sm border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter mobile number">
                        <button type="button" class="absolute right-2 top-2/4 transform -translate-y-1/2 bg-blue-500 text-white px-3 py-1 rounded-md text-xs" onclick="sendOTP();">Send OTP</button>
                        <div id="otpMessage" class="text-red-500 hidden mt-2"></div>
                    </div>
                </div>
                <div>
                    <label class="text-gray-800 text-sm block mb-2">OTP</label>
                    <input id="verificationCode" name="otp" type="text" required class="w-full bg-transparent text-sm border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter OTP">
                    <button type="button" class="absolute right-2 top-2/4 transform -translate-y-1/2 bg-blue-500 text-white px-3 py-1 rounded-md text-xs" onclick="verifyOTP();">Verify OTP</button>
                </div>
                <div>
                    <label class="text-gray-800 text-xs block mb-2">Password</label>
                    <input id="password" name="password" type="password" required class="w-full bg-transparent text-sm border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter password">
                </div>
                <div>
                    <label class="text-gray-800 text-xs block mb-2">Confirm Password</label>
                    <input id="cpassword" name="cpassword" type="password" required class="w-full bg-transparent text-sm border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter confirm password">
                </div>
            </div>
            <input type="hidden" id="otpVerified" name="otpVerified" value="false">
            <div class="flex justify-center mt-12">
                <button type="submit" id="submitBtn" name="submit" class="py-3.5 px-7 text-sm font-semibold tracking-wider rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">Sign up</button>
            </div>
        </form>
    </div>

    <script>
        function sendOTP() {
            const number = document.getElementById('number').value;
            if (number.length === 11) {
                fetch('../OTP/OTP.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        send_otp: true,
                        phone_number: number
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const messageDiv = document.getElementById('otpMessage');
                    messageDiv.classList.remove('hidden');
                    messageDiv.textContent = data.message;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to send OTP. Please try again.');
                });
            } else {
                alert("Please enter a valid mobile number.");
            }
        }

        function verifyOTP() {
            const enteredOTP = document.getElementById('verificationCode').value;
            fetch('../OTP/OTP.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    verify_otp: true,
                    otp: enteredOTP
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') {
                    document.getElementById('otpVerified').value = 'true';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to verify OTP. Please try again.');
            });
        }
    </script>
</body>

</html>
