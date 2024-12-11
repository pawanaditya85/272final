<?php
require_once 'config.php';
$conn = new mysqli("db"," user"," password"," marketplace");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
