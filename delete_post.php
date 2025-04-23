<?php
session_start();
require 'config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

header("Location: posts.php");
exit;
?>
