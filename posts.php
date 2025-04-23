<?php
session_start();
require 'config.php';

$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$totalStmt = $pdo->query("SELECT COUNT(*) FROM posts");
$totalPosts = $totalStmt->fetchColumn();
$totalPages = ceil($totalPosts / $limit);

$stmt = $pdo->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC LIMIT ?, ?");
$stmt->bindValue(1, $start, PDO::PARAM_INT);
$stmt->bindValue(2, $limit, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();
?>
<link rel="stylesheet" href="styles.css">
<div class="container">
  <h2>All Posts</h2>
  <a href="create_post.php">+ Create New Post</a>
  <?php foreach ($posts as $post): ?>
    <div style="margin-top:20px;">
      <h3><?= htmlspecialchars($post['title']) ?></h3>
      <small>by <?= $post['username'] ?> on <?= $post['created_at'] ?></small>
      <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
      <?php if ($_SESSION['user_id'] == $post['user_id']): ?>
        <a href="edit_post.php?id=<?= $post['id'] ?>">Edit</a> | 
        <a href="delete_post.php?id=<?= $post['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  
  <div class="pagination">
  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>">
      <?= $i ?>
    </a>
  <?php endfor; ?>
</div>
