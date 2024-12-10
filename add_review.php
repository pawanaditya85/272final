<?php
session_start();
require_once 'db.php';

if(!isset($_SESSION['user_id'])){
    die("You must be logged in to add a review.");
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $product_id = (int)$_POST['product_id'];
    $comment = $_POST['comment'];
    $rating = (int)$_POST['rating'];

    $stmt = $conn->prepare("INSERT INTO reviews (user_id, product_id, comment, rating) VALUES (?,?,?,?)");
    $stmt->bind_param('iisi', $_SESSION['user_id'], $product_id, $comment, $rating);
    $stmt->execute();
    $stmt->close();
    header("Location: product.php?id=".$product_id);
    exit;
}
