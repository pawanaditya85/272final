<?php
session_start();
require_once 'db.php';
if(!isset($_GET['id'])) {
    die("Product not found.");
}
$product_id = (int)$_GET['id'];
// Record visit if user is logged in
if(isset($_SESSION['user_id'])){
    $stmt = $conn->prepare("INSERT INTO visits (user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param('ii', $_SESSION['user_id'], $product_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch product info
$stmt = $conn->prepare("SELECT title, image_url, description FROM products WHERE id=?");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$stmt->bind_result($title, $image_url, $description);
if(!$stmt->fetch()){
    die("Product not found.");
}
$stmt->close();

// Fetch reviews
$reviews_stmt = $conn->prepare("SELECT r.comment, r.rating, u.username FROM reviews r JOIN users u ON r.user_id=u.id WHERE r.product_id=?");
$reviews_stmt->bind_param('i', $product_id);
$reviews_stmt->execute();
$reviews_result = $reviews_stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><title><?php echo htmlspecialchars($title); ?></title></head>
<body>
<h1><?php echo htmlspecialchars($title); ?></h1>
<img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($title); ?>" style="width:200px;height:auto;"><br>
<p><?php echo nl2br(htmlspecialchars($description)); ?></p>

<h2>Reviews</h2>
<?php while($rev = $reviews_result->fetch_assoc()): ?>
<div style="border:1px solid #ccc;padding:5px;margin:5px 0;">
<strong><?php echo htmlspecialchars($rev['username']); ?></strong> rated <?php echo (int)$rev['rating']; ?>/5<br>
<?php echo nl2br(htmlspecialchars($rev['comment'])); ?>
</div>
<?php endwhile; ?>
<?php $reviews_stmt->close(); ?>

<?php if(isset($_SESSION['user_id'])): ?>
<h3>Add a Review</h3>
<form action="add_review.php" method="post">
<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
Comment: <br><textarea name="comment" required></textarea><br>
Rating (1-5): <input type="number" name="rating" min="1" max="5" required><br>
<button type="submit">Submit Review</button>
</form>
<?php else: ?>
<p><a href="login.php">Login</a> to add a review.</p>
<?php endif; ?>

<h2>Add to Cart</h2>
<!-- Simple demonstration of "Add to Cart" -->
<form method="post">
<input type="hidden" name="add_to_cart" value="<?php echo $product_id; ?>">
<button type="submit">Add to Cart</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    // For demonstration, just show a message
    echo "<p>Product added to cart (in a real application, store in session or DB)</p>";
}
?>
<p><a href="index.php">Back to Home</a></p>
</body>
</html>
