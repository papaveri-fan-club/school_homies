<?php
include "../include/connessione.inc";
session_start();
$stmt = $conn->prepare("INSERT INTO posts (title, description, id_user, date_event) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $_POST['title'], $_POST['description'], $_SESSION['id_user'], $_POST['date_event']);
$stmt->execute();
header("Location: ../index.php");
?>