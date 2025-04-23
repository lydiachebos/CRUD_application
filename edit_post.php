<?php
session_start();
require 'config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found or access denied.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $updateStmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $updateStmt->execute([$title, $content, $id]);

    header("Location: posts.php");
    exit;
}
?>
<link rel="stylesheet" href="styles.css">
<div class="container">
  <h2>Edit Post</h2>
  <form method="post">
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
    <textarea name="content" rows="5" required><?= htmlspecialchars($post['content']) ?></textarea>
    <button type="submit">Update</button>
  </form>
  <a href="posts.php">← Back to Posts</a>
</div>
