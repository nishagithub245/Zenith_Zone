<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenithZone</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
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
    include "../Database_Connection/DB_Connection.php";

    $email_error = $number_error = '';
    $registration_success = false;
    $error_message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && $_POST['otpVerified'] === "true") {
        $first_name = htmlspecialchars($_POST['fname']);
        $last_name = htmlspecialchars($_POST['lname']);
        $email = htmlspecialchars($_POST['email']);
        $mobile_number = htmlspecialchars($_POST['number']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("
            SELECT email, mobile_number FROM customer_info WHERE email = ? OR mobile_number = ?
            UNION
            SELECT email, mobile_number FROM artist_info WHERE email = ? OR mobile_number = ?
            UNION
            SELECT email, mobile_number FROM sellersinfo WHERE email = ? OR mobile_number = ?
        ");
        $stmt->bind_param("ssssss", $email, $mobile_number, $email, $mobile_number, $email, $mobile_number);
        $stmt->execute();
        $stmt->bind_result($dbEmail, $dbMobileNumber);
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                if ($email === $dbEmail) {
                    $email_error = "Email already registered. Please try another.";
                }
                if ($mobile_number === $dbMobileNumber) {
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
        // $error_message = "OTP verification failed. Please verify your OTP before submitting the form.";
    }

    // Direct PHP-driven modals:
    if ($registration_success) {
        echo '<dialog id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">';
        echo '<div class="bg-white rounded-lg p-5 shadow text-center">';
        echo '<i class="fa-solid fa-circle-check fa-5x" style="color: #3feeba;"></i>';
        echo '<h3 class="text-lg font-bold mt-4">Registration Successful!</h3>';
        echo '<p class="mt-2 text-green-700">You have successfully registered.</p>';
        echo '<div class="flex justify-center mt-4">';
        echo '<button onclick="window.location=\'../HomePage/InitialPage1.php\';" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Close</button>';
        echo '</div>';
        echo '</div>';
        echo '</dialog>';
        echo "<script>document.getElementById('successModal').showModal();</script>";
    } elseif (!empty($email_error) || !empty($number_error)) {
        $error_message = !empty($email_error) ? $email_error : $number_error;
        echo '<dialog id="errorModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">';
        echo '<div class="bg-white rounded-lg p-5 shadow text-center">';
        echo '<i class="fa-solid fa-circle-xmark fa-5x" style="color: #ff4b0f;"></i>';
        echo '<h3 class="text-lg font-bold text-red-700 mt-4">Registration Error</h3>';
        echo "<p class='mt-2'>$error_message</p>";
        echo '<div class="flex justify-center mt-4">';
        echo '<button onclick="window.location=\'./customerreg.php\';" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Close</button>';
        echo '</div>';
        echo '</div>';
        echo '</dialog>';
        echo "<script>document.getElementById('errorModal').showModal();</script>";
    }
    ?>

    <?php
    include "../Header_Footer/header.php";
    ?>


    <div class="mt-5 mb-5 max-w-4xl mx-auto font-[sans-serif] p-6 bg-gray-100 rounded-lg">
        <form id="signupForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" onsubmit="return checkOTPVerification();">
            <h1 class="text-center font-bold text-black text-xl">Create your ZenithZone Account</h1>
            <div class="grid sm:grid-cols-2 gap-8">
                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">First Name</label>
                    <div class="relative flex items-center">
                        <input id="fname" name="fname" type="text" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter first name" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 24 24">
                            <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                            <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                        </svg>
                    </div>
                    <div id="fname-error" class="error-message">First name should not contain numbers.</div>
                </div>
                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">Last Name</label>
                    <div class="relative flex items-center">
                        <input id="lname" name="lname" type="text" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter last name" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 24 24">
                            <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                            <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                        </svg>
                    </div>
                    <div id="lname-error" class="error-message">Last name should not contain numbers.</div>
                </div>
                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">Email Id</label>
                    <div class="relative flex items-center">
                        <input id="email" name="email" type="email" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter email" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 682.667 682.667">
                            <defs>
                                <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                    <path d="M0 512h512V0H0Z" data-original="#000000"></path>
                                </clipPath>
                            </defs>
                            <g clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                                <path fill="none" stroke-miterlimit="10" stroke-width="40" d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z" data-original="#000000"></path>
                                <path d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z" data-original="#000000"></path>
                            </g>
                        </svg>
                    </div>
                    <div id="email-error" class="error-message">Please enter a valid email address.</div>
                </div>
                <div class="mt-8">
                    <label class="text-gray-800 text-sm block mb-2">Mobile No.</label>
                    <div class="relative flex items-center">
                        <input id="number" name="number" type="text" required class="w-full bg-transparent text-sm border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter mobile number">
                        <button type="button" class="absolute right-2 top-2/4 transform -translate-y-1/2 bg-blue-500 text-white px-3 py-1 rounded-md text-xs" onclick="sendOTP();">Send OTP</button>
                    </div>
                    <div id="otpMessage" class="text-red-500 hidden mt-2"></div>
                    <div id="number-error" class="error-message text-red-500 text-xs hidden mt-2">Mobile number must be 11 digits.</div>
                    <div id="errorDisplay" class="hidden text-red-500"></div>
                </div>
                <div class="mt-8">
                    <label class="text-gray-800 text-sm block mb-2">OTP</label>
                    <div class="relative flex items-center">
                        <input id="verificationCode" name="otp" type="text" required class="w-full bg-transparent text-sm border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter OTP">
                        <button type="button" class="absolute right-2 top-2/4 transform -translate-y-1/2 bg-blue-500 text-white px-3 py-1 rounded-md text-xs" onclick="verifyOTP();">Verify OTP</button>
                    </div>
                </div>
                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">Password</label>
                    <div class="relative flex items-center">
                        <input id="password" name="password" type="password" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter password" />
                        <svg onclick="togglePasswordVisibility('password', this)" xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2 cursor-pointer" viewBox="0 0 128 128">
                            <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                        </svg>
                    </div>
                    <div id="password-error" class="error-message">Password must be at least 6 characters long.</div>
                </div>
                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">Confirm Password</label>
                    <div class="relative flex items-center">
                        <input id="cpassword" name="cpassword" type="password" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter confirm password" />
                        <svg onclick="togglePasswordVisibility('cpassword', this)" xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2 cursor-pointer" viewBox="0 0 128 128">
                            <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                        </svg>
                    </div>
                    <div id="cpassword-error" class="error-message">Passwords do not match.</div>
                </div>
            </div>
            <input type="hidden" id="otpVerified" name="otpVerified" value="false">
            <div class="flex justify-center mt-12">
                <button type="submit" id="submitBtn" name="submit" class="py-3.5 px-7 text-sm font-semibold tracking-wider rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">Sign up</button>
            </div>
        </form>
    </div>

    <!-- Modal Structure -->
    <div id="messageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-5 shadow text-center">
            <i id="modalIcon" class="fa-solid fa-circle-check fa-5x"></i>
            <h3 id="modalTitle" class="text-lg font-bold mt-4">Title Here</h3>
            <p id="modalMessage" class="mt-2">Message Here</p>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registrationSuccess = <?php echo json_encode($registration_success); ?>;
            const errorMessage = <?php echo json_encode($error_message); ?>;

            if (registrationSuccess) {
                document.getElementById('successModal').showModal();
            } else if (errorMessage) {
                document.getElementById('modalErrorMessage').textContent = errorMessage;
                document.getElementById('errorModal').showModal();
            }
        });
    </script>

    <script src="./ValidateRegistration.js"></script>
    <script>
        const registrationSuccess = <?php echo json_encode($registration_success); ?>;
        const errorMessage = <?php echo json_encode($error_message); ?>;
    </script>
    <script src="./OTP.js"></script>



    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-5 shadow text-center">
            <i class="fa-solid fa-circle-check fa-5x" style="color: #3feeba;"></i>
            <h3 class="text-lg font-bold mt-4">Title Here</h3>
            <p class="mt-2">Message Here</p>
            <button onclick="document.getElementById('successModal').classList.add('hidden')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Close</button>
        </div>
    </div>


    <!--
- ionicon link
-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


    <!-- Modal Structure -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-5 shadow text-center">
            <i class="fa-solid fa-circle-check fa-5x" style="color: #3feeba;"></i>
            <h3 class="text-lg font-bold mt-4">OTP Verified</h3>
            <p class="mt-2">Your OTP has been verified successfully.</p>
            <button onclick="document.getElementById('successModal').style.display = 'none'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Close</button>
        </div>
    </div>
</body>

</html>