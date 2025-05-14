<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$id_post = $_POST['id_post'];

// Controlla se l'utente è un amministratore
$stmt = $conn->prepare("SELECT user_type FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['user_type'] === 'amministratore') {
    // Gli amministratori possono eliminare qualsiasi post
    $query = $conn->prepare("DELETE FROM posts WHERE id_post = ?");
    $query->bind_param("i", $id_post);
} else {
    // Gli utenti normali possono eliminare solo i propri post
    $query = $conn->prepare("DELETE FROM posts WHERE id_post = ? AND id_user = ?");
    $query->bind_param("ii", $id_post, $id_user);
}

$query->execute();
header('Location: ../../pub/profile.php');
exit();
?>