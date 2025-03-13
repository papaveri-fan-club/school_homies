<?php
include "./include/start.inc";
$stmt = $conn->prepare("INSERT INTO posts (text, user_id) VALUES (?, ?)");
$stmt->bind_param("si", $_POST['text'], $_SESSION['user_id']);
$stmt->execute();
header("Location: ./index.php");
?>