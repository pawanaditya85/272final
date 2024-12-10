<?php
session_start();
require_once 'db.php';

// Fetch top 5 most visited products
$sql = "SELECT p.id, p.title, p.image_url, COUNT(v.id) as visit_count 
        FROM products p 
        LEFT JOIN visits v ON p.id = v.product_id
        GROUP BY p.id
        ORDER BY visit_count DESC
        LIMIT 5";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head><title>Top 5 Products</title></head>
<body>
<h1>Top 5 Most Visited Products/Services</h1>
<ol>
<?php while($row = $result->fetch_assoc()): ?>
    <li>
        <a href="product.php?id=<?php echo $row['id']; ?>">
            <img src="<?php echo $row['image_url']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width:50px;height:50px;">
            <?php echo htmlspecialchars($row['title']); ?> (Visits: <?php echo $row['visit_count']; ?>)
        </a>
    </li>
<?php endwhile; ?>
</ol>
<p><a href="index.php">Back to Home</a></p>
</body>
</html>
