<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // In production, verify using password_verify
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username=? AND password=? LIMIT 1");
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows == 1){
        $stmt->bind_result($id, $usern);
        $stmt->fetch();
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $usern;
        header("Location: index.php");
        exit;
    } else {
        echo "Invalid credentials";
    }
    $stmt->close();
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h1>Login</h1>
<form method="post">
Username: <input type="text" name="username" required><br>
Password: <input type="password" name="password" required><br>
<button type="submit">Login</button>
</form>
</body>
</html>
