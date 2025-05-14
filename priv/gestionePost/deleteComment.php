<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../../pub/login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$id_comment = $_POST['id_comment'] ?? null;

if (!$id_comment) {
    die("Errore: ID del commento mancante.");
}

// Recupera informazioni sul commento
$stmt = $conn->prepare("SELECT id_user FROM comments WHERE id_comment = ?");
$stmt->bind_param("i", $id_comment);
$stmt->execute();
$result = $stmt->get_result();
$comment = $result->fetch_assoc();

if (!$comment) {
    die("Errore: Commento non trovato.");
}

// Controlla se l'utente è autorizzato a eliminare il commento
if ($comment['id_user'] == $id_user || (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'amministratore')) {
    // Elimina il commento
    $query = $conn->prepare("DELETE FROM comments WHERE id_comment = ?");
    $query->bind_param("i", $id_comment);
    $query->execute();

    // Reindirizza alla pagina precedente
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    die("Errore: Non hai i permessi per eliminare questo commento.");
}
?>