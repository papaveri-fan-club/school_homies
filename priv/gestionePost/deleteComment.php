<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$id_comment = $_POST['id_comment'];

// Controlla se l'utente è un amministratore
$stmt = $conn->prepare("SELECT user_type FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['user_type'] === 'amministratore') {
    // Gli amministratori possono eliminare qualsiasi commento
    $query = $conn->prepare("DELETE FROM comments WHERE id_comment = ?");
    $query->bind_param("i", $id_comment);
} else {
    // Gli utenti normali possono eliminare solo i propri commenti
    $query = $conn->prepare("DELETE FROM comments WHERE id_comment = ? AND id_user = ?");
    $query->bind_param("ii", $id_comment, $id_user);
}

$query->execute();
header('Location: ../../pub/profile.php');
exit();
?>