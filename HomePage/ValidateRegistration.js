document.addEventListener("DOMContentLoaded", function () {
    const nameRegex = /^[a-zA-Z][a-zA-Z\s]*$/;
    const numberRegex = /^\d{11}$/;

    validateField(
        "fname",
        (value) => nameRegex.test(value),
        "First name should only contain letters and spaces, and must start with a letter."
    );
    validateField(
        "lname",
        (value) => nameRegex.test(value),
        "Last name should only contain letters and spaces, and must start with a letter."
    );
    validateField(
        "number",
        (value) => numberRegex.test(value),
        "Mobile number must be 11 digits."
    );
    validateField(
        "password",
        (value) => value.length >= 6,
        "Password must be at least 6 characters long."
    );
    validateField(
        "cpassword",
        (value) => value === document.getElementById("password").value,
        "Passwords do not match."
    );
    validateField(
        "nid",
        (value) => /^\d{10}$|^\d{13}$|^\d{17}$/.test(value),
        "Provide correct NID Number"
    );
    validateField(
        "postal",
        (value) => /^\d+$/.test(value),
        "Postal code should be numeric."
    );

    document
        .getElementById("signupForm")
        .addEventListener("submit", function (event) {
            const fname = document.getElementById("fname").value;
            const lname = document.getElementById("lname").value;
            const number = document.getElementById("number").value;
            const password = document.getElementById("password").value;
            const cpassword = document.getElementById("cpassword").value;
            const nid = document.getElementById("nid").value;
            const postal = document.getElementById("postal").value;
            const ownPicture = document.getElementById("own-picture").files[0];
            const nidPicture = document.getElementById("nid-picture").files[0];

            let valid = true;

            if (!nameRegex.test(fname)) {
                showError(
                    "fname",
                    "First name should not contain numbers, and must start with a letter."
                );
                valid = false;
            }
            if (!nameRegex.test(lname)) {
                showError(
                    "lname",
                    "Last name should not contain numbers., and must start with a letter."
                );
                valid = false;
            }
            if (!numberRegex.test(number)) {
                showError("number", "Mobile number must be 11 digits.");
                valid = false;
            }
            if (password.length < 6) {
                showError("password", "Password must be at least 6 characters long.");
                valid = false;
            }
            if (password !== cpassword) {
                showError("cpassword", "Passwords do not match.");
                valid = false;
            }
            if (!/^\d{10}$|^\d{13}$|^\d{17}$/.test(nid)) {
                showError("nid", "Provide correct NID Number");
                valid = false;
            }
            if (!/^\d+$/.test(postal)) {
                showError("postal", "Postal code should be numeric.");
                valid = false;
            }
            if (!ownPicture) {
                showError("own-picture", "Please upload your picture.");
                valid = false;
            }
            if (!nidPicture) {
                showError("nid-picture", "Please upload your NID picture.");
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
                document.getElementById("formErrorModal").showModal();
            }
        });
});

function showError(fieldId, message) {
    const errorElement = document.getElementById(`${fieldId}-error`);
    errorElement.innerText = message;
    errorElement.style.display = "block";
}

function hideError(fieldId) {
    const errorElement = document.getElementById(`${fieldId}-error`);
    errorElement.style.display = "none";
}

function validateField(fieldId, validator, errorMessage) {
    const field = document.getElementById(fieldId);
    field.addEventListener("blur", function () {
        if (!validator(field.value)) {
            showError(fieldId, errorMessage);
        } else {
            hideError(fieldId);
        }
    });
}

function togglePasswordVisibility(id, eyeIcon) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        eyeIcon.setAttribute("fill", "#666");
    } else {
        input.type = "password";
        eyeIcon.setAttribute("fill", "#bbb");
    }
}
