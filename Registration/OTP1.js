let isOtpVerified = false;

function checkOTPVerification() {
    // Prevent form submission if OTP is not verified
    if (!isOtpVerified) {
        alert('Please verify your OTP before submitting the form.');
        return false;
    }
    return true;
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

    // Validate OTP length before sending
    if (enteredOTP.length !== 6) {
        alert("Please enter a valid 6-digit OTP.");
        return;
    }

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
                isOtpVerified = true;
                document.getElementById("otpVerified").value = "true";
                document.getElementById("submitBtn").disabled = false;
                showSuccessModal("OTP Verified", "Your OTP has been verified successfully.");
            } else {
                isOtpVerified = false;
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Failed to verify OTP. Please try again.");
        });
}

function showSuccessModal(title, message) {
    const modal = document.getElementById("successModal");
    modal.querySelector("h3").textContent = title;
    modal.querySelector("p").textContent = message;
    modal.classList.remove("hidden");
}

function closeModal() {
    const modal = document.getElementById("successModal");
    modal.classList.add("hidden");
}

function resetOTPState() {
    isOtpVerified = false;
    document.getElementById("otpVerified").value = "false";
    document.getElementById("verificationCode").value = "";
    document.getElementById("otpMessage").classList.add("hidden");
    document.getElementById("submitBtn").disabled = true;
}
