<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to homepage.php after logout
header("Location: ../Homepage/InitialPage1.php");
exit; // Ensure no further code is executed after the redirect
?>
