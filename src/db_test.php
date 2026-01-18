<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

// 1. Check if connect.php exists
if (!file_exists('connect.php')) {
    die("<p style='color:red;'><strong>Error:</strong> connect.php not found.</p>");
}
require_once 'connect.php';
echo "<p><strong>OK:</strong> connect.php loaded.</p>";

// 2. Check if $G_DB variable is set
if (!isset($G_DB) || !is_array($G_DB)) {
    die("<p style='color:red;'><strong>Error:</strong> \$G_DB configuration is missing in connect.php.</p>");
}
echo "<p><strong>OK:</strong> \$G_DB configuration found.</p>";
echo "<pre>Using configuration: " . htmlspecialchars(print_r($G_DB, true)) . "</pre>";

// 3. Attempt connection
echo "<p>Attempting to connect to database...</p>";
// Use @ to suppress the default warning, as we are handling the error manually.
$mysqli = new mysqli($G_DB['SERVER'], $G_DB['SERVER_USERNAME'], $G_DB['SERVER_PASSWORD'], $G_DB['DATEBASE'], $G_DB['PORT']);

// 4. Check for connection error
if ($mysqli->connect_errno) {
    echo "<p style='color:red;'><strong>Connection Failed!</strong></p>";
    echo "<p><strong>Error Number:</strong> " . $mysqli->connect_errno . "</p>";
    echo "<p><strong>Error Message:</strong> " . htmlspecialchars($mysqli->connect_error) . "</p>";
    die("<p>Please double-check your database credentials in connect.php. The error message above is the key.</p>");
}

echo "<p style='color:green;'><strong>Success!</strong> Database connection is working correctly.</p>";

$mysqli->close();
?>
