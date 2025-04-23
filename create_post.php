<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $title, $content]);

    header("Location: posts.php");
    exit;
}
?>
<link rel="stylesheet" href="styles.css">
<div class="container">
  <h2>Create Post</h2>
  <form method="post">
    <input type="text" name="title" placeholder="Post Title" required>
    <textarea name="content" placeholder="Post Content" rows="5" required></textarea>
    <button type="submit">Publish</button>
  </form>
  <a href="posts.php">← Back to Posts</a>
</div>
