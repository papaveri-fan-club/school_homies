<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../../pub/login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$id_folder = $_POST['id_folder'] ?? null;

if (!$id_folder) {
    die("Errore: ID della cartella mancante.");
}

// Recupera informazioni sulla cartella
$stmt = $conn->prepare("SELECT id_user, type FROM folders WHERE id_folder = ?");
$stmt->bind_param("i", $id_folder);
$stmt->execute();
$result = $stmt->get_result();
$folder = $result->fetch_assoc();

if (!$folder) {
    die("Errore: Cartella non trovata.");
}

// Controlla se l'utente è autorizzato a eliminare la cartella
if ($folder['id_user'] == $id_user) {
    // L'utente può eliminare le proprie cartelle
    $query = $conn->prepare("DELETE FROM folders WHERE id_folder = ?");
    $query->bind_param("i", $id_folder);
    $query->execute();
    header('Location: ../../pub/profile.php?id_user=' . $folder['id_user']);
    exit();
} elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'amministratore' && $folder['type'] === 'public' && $folder['id_user'] != $id_user) {
    // Gli amministratori possono eliminare solo cartelle pubbliche di altri utenti
    $query = $conn->prepare("DELETE FROM folders WHERE id_folder = ? AND type = 'public'");
    $query->bind_param("i", $id_folder);
    $query->execute();
    header('Location: ../../pub/profile.php?id_user=' . $folder['id_user']);
    exit();
} else {
    die("Errore: Non hai i permessi per eliminare questa cartella.");
}
?>