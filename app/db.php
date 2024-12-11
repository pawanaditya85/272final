<?php
require_once 'config.php';

$conn = new mysqli("db", "user", "password", "marketplace");

// Debugging connection
echo $conn->ping() ? "Connected successfully" : "Connection failed";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
