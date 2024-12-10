<?php
session_start();
require_once 'db.php';
$result = $conn->query("SELECT id, title, image_url FROM products");
?>
<!DOCTYPE html>
<html>
<head><title>Marketplace</title></head>
<body>
<?php if(isset($_SESSION['user_id'])): ?>
    <p>Welcome, <?php echo $_SESSION['username']; ?>! <a href="logout.php">Logout</a></p>
<?php else: ?>
    <p><a href="register.php">Register</a> or <a href="login.php">Login</a></p>
<?php endif; ?>
<h1>All Products and Services</h1>
<div style="display:flex;flex-wrap:wrap;">
<?php while($row = $result->fetch_assoc()): ?>
    <div style="margin:10px;">
        <a href="product.php?id=<?php echo $row['id']; ?>">
            <img src="<?php echo $row['image_url']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width:100px;height:100px;"><br>
            <?php echo htmlspecialchars($row['title']); ?>
        </a>
    </div>
<?php endwhile; ?>
</div>
<p><a href="top.php">View Top 5 Most Visited</a></p>
</body>
</html>
