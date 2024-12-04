<?php
session_start();

function send_otp($number, $otp) {
    $api_key = "ltXBwd4xGgNyIK3kzOe5"; // Replace with your actual API key
    $senderid = "8809617622501"; // Replace with your actual Sender ID
    $message = "Your ZenithZone OTP code is: $otp. Please do not share this with anyone.";

    $url = "http://bulksmsbd.net/api/smsapi?api_key=$api_key&type=text&number=$number&senderid=$senderid&message=" . urlencode($message);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);

    if ($response === false) {
        error_log('cURL Error: ' . curl_error($ch));
        return 'cURL Error: ' . curl_error($ch);
    }

    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    error_log("HTTP Status: $http_status, Response: $response");

    if ($http_status !== 200) {
        return "HTTP Error $http_status: $response";
    }

    return $response;
}


$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send_otp']) && !empty($_POST['phone_number'])) {
        $number = $_POST['phone_number'];
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['phone_number'] = $number;

        $response = send_otp($number, $otp);
        echo json_encode(['status' => 'success', 'message' => 'OTP sent! Please check your phone.', 'response' => $response]);
        exit;
    } elseif (isset($_POST['verify_otp']) && !empty($_POST['otp'])) {
        $entered_otp = $_POST['otp'];
        if ($entered_otp == $_SESSION['otp']) {
            unset($_SESSION['otp']);
            unset($_SESSION['phone_number']);
            echo json_encode(['status' => 'success', 'message' => 'OTP verified successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid OTP. Please try again.']);
        }
        exit;
    }
}
?>