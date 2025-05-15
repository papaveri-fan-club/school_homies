<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../../pub/login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$id_post = $_POST['id_post'] ?? null;

if (!$id_post) {
    die("Errore: ID del post mancante.");
}

// Recupera il proprietario del post
$stmt = $conn->prepare("SELECT id_user FROM posts WHERE id_post = ?");
$stmt->bind_param("i", $id_post);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("Errore: Post non trovato.");
}

// Controlla se l'utente è autorizzato a eliminare il post
if ($post['id_user'] == $id_user || (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'amministratore')) {
    // Elimina il post
    $query = $conn->prepare("DELETE FROM posts WHERE id_post = ?");
    $query->bind_param("i", $id_post);
    $query->execute();

    // Reindirizza alla pagina del profilo o alla home
    if (basename($_SERVER['HTTP_REFERER']) === 'profile.php') {
        header('Location: ../../pub/index.php');
    } else {
        header('Location: ../../pub/index.php');
    }
    exit();
} else {
    die("Errore: Non hai i permessi per eliminare questo post.");
}
?>