<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenithZone - OTP Verification</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="../assets/images/logo/ZenithZone.png" type="image/x-icon">
</head>

<body class="bg-gray-50 font-poppins">

    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">ZenithZone - OTP Verification</h2>

            <form id="mobile-otp-form" action="/submit" method="POST" onsubmit="return checkOTPVerification();">
                <!-- Mobile Number Section -->
                <div class="mb-4">
                    <label for="number" class="block text-gray-700 font-medium">Mobile Number:</label>
                    <input type="text" id="number" name="mobileNumber" placeholder="Enter your mobile number"
                        class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required />
                </div>

                <!-- OTP Section -->
                <div class="mb-4">
                    <button type="button" id="sendOtpButton"
                        class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg focus:outline-none hover:bg-indigo-700"
                        onclick="sendOTP()">Send OTP</button>
                    <p id="otpMessage" class="text-green-500 mt-2 hidden text-center"></p>
                </div>

                <!-- OTP Verification Section -->
                <div class="mb-4">
                    <label for="verificationCode" class="block text-gray-700 font-medium">Enter OTP:</label>
                    <input type="text" id="verificationCode" name="verificationCode" placeholder="Enter OTP"
                        class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    <button type="button"
                        class="w-full py-3 mt-3 bg-indigo-600 text-white font-semibold rounded-lg focus:outline-none hover:bg-indigo-700"
                        onclick="verifyOTP()">Verify OTP</button>
                </div>

                <!-- Hidden field to indicate OTP verification -->
                <input type="hidden" name="otpVerified" id="otpVerified" value="false" />

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" id="submitBtn"
                        class="w-full py-3 bg-gray-400 text-white font-semibold rounded-lg focus:outline-none cursor-not-allowed"
                        disabled>Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-2xl font-semibold text-gray-800"></h3>
            <p class="text-gray-600 mt-4"></p>
            <button class="mt-6 py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700"
                onclick="closeModal()">Close</button>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="OTP1.js"></script>
</body>

</html>
