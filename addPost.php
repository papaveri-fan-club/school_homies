<?php
include "./include/start.inc";
$stmt = $conn->prepare("INSERT INTO posts (text, id_user) VALUES (?, ?)");
$stmt->bind_param("si", $_POST['text'], $_SESSION['id_user']);
$stmt->execute();
header("Location: ./index.php");
?>