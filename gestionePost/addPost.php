<?php
include "../include/connessione.inc";
session_start();
$stmt = $conn->prepare("INSERT INTO posts (title, description, id_user) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $_POST['title'], $_POST['description'], $_SESSION['id_user']);
$stmt->execute();
header("Location: ../index.php");
?>