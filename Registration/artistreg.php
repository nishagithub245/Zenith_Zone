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

  $email_error = $number_error = $nid_error = '';
  $registration_success = false;
  $upload_error = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])  && $_POST['otpVerified'] === "true") {
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $mobile_number = $_POST['number'];
    $gender = $_POST['gender'];
    $nid_number = $_POST['nid'];
    $date_of_birth = $_POST['dob'];
    $address = trim($_POST['address']); // Capture the address field
    $postal_code = $_POST['postal'];
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check for existing email, mobile number, or NID number
    $stmt = $conn->prepare("SELECT email, mobile_number, nid_number FROM artist_info WHERE email = ? OR mobile_number = ? OR nid_number = ?");
    $stmt->bind_param("sss", $email, $mobile_number, $nid_number);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        if ($row['email'] === $email) {
          $email_error = "Email already registered. Please try another.";
        }
        if ($row['mobile_number'] === $mobile_number) {
          $number_error = "Mobile number already registered. Please try another.";
        }
        if ($row['nid_number'] === $nid_number) {
          $nid_error = "NID number already registered. Please try another.";
        }
      }
    } else {
      // File upload handling
      if (
        isset($_FILES['own_picture']) && $_FILES['own_picture']['error'] === UPLOAD_ERR_OK &&
        isset($_FILES['nid_picture']) && $_FILES['nid_picture']['error'] === UPLOAD_ERR_OK
      ) {
        $artist_picture_extension = pathinfo($_FILES['own_picture']['name'], PATHINFO_EXTENSION);
        $nid_picture_extension = pathinfo($_FILES['nid_picture']['name'], PATHINFO_EXTENSION);
        $artist_picture_newname = "artistpic/" . $mobile_number . "." . $artist_picture_extension;
        $nid_picture_newname = "artistnid/" . $mobile_number . "." . $nid_picture_extension;

        // Ensure directories exist
        if (!file_exists("artistpic/")) {
          mkdir("artistpic/", 0777, true);
        }
        if (!file_exists("artistnid/")) {
          mkdir("artistnid/", 0777, true);
        }

        // Move files
        move_uploaded_file($_FILES["own_picture"]["tmp_name"], $artist_picture_newname);
        move_uploaded_file($_FILES["nid_picture"]["tmp_name"], $nid_picture_newname);

        // Insert into database
        $insert_stmt = $conn->prepare("INSERT INTO artist_info (first_name, last_name, email, mobile_number, gender, nid_number, date_of_birth, address, postal_code, artist_picture, nid_picture, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("ssssssssssss", $first_name, $last_name, $email, $mobile_number, $gender, $nid_number, $date_of_birth, $address, $postal_code, $artist_picture_newname, $nid_picture_newname, $password_hash);

        if ($insert_stmt->execute()) {
          $registration_success = true;
        }
        $insert_stmt->close();
      } else {
        $upload_error = "Error uploading files. Please check file size and format.";
      }
    }
    $stmt->close();
  }

  $conn->close();

  // Modals for feedback
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
  } elseif (!empty($email_error) || !empty($number_error) || !empty($nid_error) || !empty($upload_error)) {
    $error_message = !empty($email_error) ? $email_error : (!empty($number_error) ? $number_error : (!empty($nid_error) ? $nid_error : $upload_error));
    echo '<dialog id="errorModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">';
    echo '<div class="bg-white rounded-lg p-5 shadow text-center">';
    echo '<i class="fa-solid fa-circle-xmark fa-5x" style="color: #ff4b0f;"></i>';
    echo '<h3 class="text-lg font-bold text-red-700 mt-4">Registration Error</h3>';
    echo "<p class='mt-2'>$error_message</p>";
    echo '<div class="flex justify-center mt-4">';
    echo '<button onclick="window.location=\'./artistreg.php\';" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Close</button>';
    echo '</div>';
    echo '</div>';
    echo '</dialog>';
    echo "<script>document.getElementById('errorModal').showModal();</script>";
  }
  ?>


  <?php
  include "../Header_Footer/header.php";
  ?>

  <div class="bg-[url('./RegBG.jpg')] min-h-screen flex items-center justify-center">
    <!-- This Div for form of the registration -->
    <div class="mt-4 mb-5 max-w-4xl mx-auto font-[sans-serif] p-6 bg-gray-100  rounded-lg">
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
            <div id="fname-error" class="error-message">
              First name should not contain numbers.
            </div>
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
            <div id="lname-error" class="error-message">
              Last name should not contain numbers.
            </div>
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
            <label class="text-gray-800 text-xs block mb-2">Password</label>
            <div class="relative flex items-center">
              <input id="password" name="password" type="password" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter password" />
              <svg onclick="togglePasswordVisibility('password', this)" xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2 cursor-pointer" viewBox="0 0 128 128">
                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
              </svg>
            </div>
            <div id="password-error" class="error-message">
              Password must be at least 6 characters long.
            </div>
          </div>
          <div class="mt-8">
            <label class="text-gray-800 text-xs block mb-2">Confirm Password</label>
            <div class="relative flex items-center">
              <input id="cpassword" name="cpassword" type="password" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter confirm password" />
              <svg onclick="togglePasswordVisibility('cpassword', this)" xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2 cursor-pointer" viewBox="0 0 128 128">
                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
              </svg>
            </div>
            <div id="cpassword-error" class="error-message">
              Passwords do not match.
            </div>
          </div>
          <div class="mt-8">
            <label class="text-gray-800 text-xs block mb-2">Gender</label>
            <div class="relative flex items-center">
              <select id="gender" name="gender" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none">
                <option value="" disabled selected>Select gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div id="gender-error" class="error-message">
              Please select your gender.
            </div>
          </div>
          <div class="mt-8">
            <label class="text-gray-800 text-xs block mb-2">NID Number</label>
            <div class="relative flex items-center">
              <input id="nid" name="nid" type="text" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter NID number" />
            </div>
            <div id="nid-error" class="error-message">
              NID number must be exactly 10, 13, or 17 digits long and contain
              only numbers.
            </div>
          </div>
          <div class="mt-8">
            <label class="text-gray-800 text-xs block mb-2">Date of Birth</label>
            <div class="relative flex items-center">
              <input id="dob" name="dob" type="date" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" style="color: black" />
            </div>
            <div id="dob-error" class="error-message">
              Please enter a valid date of birth.
            </div>
          </div>
          <div class="mt-8">
            <label class="text-gray-800 text-xs block mb-2">Address</label>
            <div class="relative flex items-center">
              <textarea id="address" name="address" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter your address"></textarea>
            </div>
          </div>
          <div class="mt-8">
            <label class="text-gray-800 text-xs block mb-2">Postal Code</label>
            <div class="relative flex items-center">
              <input id="postal" name="postal" type="text" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter postal code" />
              <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 24 24">
                <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 17h-2v-2h2zm0-4h-2V7h2z" />
              </svg>
            </div>
            <div id="postal-error" class="error-message">
              Postal code should be numeric.
            </div>
          </div>
          <div class="mt-8">
            <label class="text-gray-800 text-xs block mb-2">Upload Your Picture</label>
            <div class="relative flex items-center">
              <input id="own-picture" name="own_picture" type="file" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" />
            </div>
            <div id="own-picture-error" class="error-message">
              Please upload your picture.
            </div>
          </div>
          <div class="mt-8">
            <label class="text-gray-800 text-xs block mb-2">Upload NID Picture</label>
            <div class="relative flex items-center">
              <input id="nid-picture" name="nid_picture" type="file" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" />
              <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 24 24">
                <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 17h-2v-2h2zm0-4h-2V7h2z" />
              </svg>
            </div>
            <div id="nid-picture-error" class="error-message">
              Please upload your NID picture.
            </div>
          </div>
        </div>
        <input type="hidden" id="otpVerified" name="otpVerified" value="false">
        <div class="flex justify-center mt-12">
          <button type="submit" id="submitBtn" name="submit" class="py-3.5 px-7 text-sm font-semibold tracking-wider rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">Sign up</button>
        </div>
      </form>
    </div>
  </div>


  <!-- Modal Structure -->
  <div id="messageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-5 shadow text-center">
      <i id="modalIcon" class="fa-solid fa-circle-check fa-5x"></i>
      <h3 id="modalTitle" class="text-lg font-bold mt-4">Title Here</h3>
      <p id="modalMessage" class="mt-2">Message Here</p>
    </div>
  </div>

  <?php
  include '../Header_Footer/footer.php';
  ?>

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