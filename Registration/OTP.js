let isOtpVerified = false;

function checkOTPVerification() {
    // Check if the OTP has been verified
    if (!isOtpVerified) {
        alert('Please verify your OTP before submitting the form.');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}

function sendOTP() {
    const number = document.getElementById("number").value;
    if (number.length === 11) {
        fetch("./OTP.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({
                    send_otp: true,
                    phone_number: number,
                }),
            })
            .then((response) => response.json())
            .then((data) => {
                const messageDiv = document.getElementById("otpMessage");
                messageDiv.classList.remove("hidden");
                messageDiv.textContent = data.message;
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Failed to send OTP. Please try again.");
            });
    } else {
        alert("Please enter a valid mobile number.");
    }
}

function verifyOTP() {
    const enteredOTP = document.getElementById("verificationCode").value;
    fetch("./OTP.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                verify_otp: true,
                otp: enteredOTP,
            }),
        })
        .then((response) => response.json())
        .then((data) => {
            alert(data.message);
            if (data.status === "success") {
                isOtpVerified = true; // Set OTP verification flag to true
                document.getElementById("otpVerified").value = "true";
                showSuccessModal("OTP Verified", "Your OTP has been verified successfully.");
            } else {
                isOtpVerified = false; 
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Failed to verify OTP. Please try again.");
            isOtpVerified = false;
        });
}

function showSuccessModal(title, message) {
    const modal = document.getElementById("successModal");
    modal.querySelector("h3").textContent = title;
    modal.querySelector("p").textContent = message;
    modal.classList.remove("hidden");
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof registrationSuccess !== 'undefined' && registrationSuccess) {
        showSuccessModal("Registration Successful!", "You have successfully registered.");
    } else if (typeof errorMessage !== 'undefined' && errorMessage) {
        alert(errorMessage);
    }
});
