<?php
session_start();
include "../Database_Connection/DB_Connection.php";

// Define a map of actions to corresponding PHP files
$contentFiles = [
    'profile' => 'profile.php',
    'edit_profile' => 'edit_profile.php',
    'home' => 'home.php',
    'services' => 'services.php',
    'settings' => 'settings.php'
];

// Check if 'action' parameter is set in the request
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Check if the requested action exists in the map
    if (array_key_exists($action, $contentFiles)) {
        include $contentFiles[$action]; // Include the corresponding PHP file
    } else {
        echo "Content not found!";
    }
} else {
    echo "No action specified!";
}
?>
