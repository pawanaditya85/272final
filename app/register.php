<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // In production, use password_hash: $hashed = password_hash($password, PASSWORD_BCRYPT);
    $hashed = md5($password); 
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param('ss', $username, $hashed);
    if ($stmt->execute()) {
        echo "User registered! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: ".$conn->error;
    }
    $stmt->close();
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h1>Register</h1>
<form method="post">
Username: <input type="text" name="username" required><br>
Password: <input type="password" name="password" required><br>
<button type="submit">Register</button>
</form>
</body>
</html>
