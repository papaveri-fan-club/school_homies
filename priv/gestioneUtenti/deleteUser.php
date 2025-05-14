<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../../pub/login.php');
    exit();
}

// Verifica se l'utente è un amministratore
if ($_SESSION['user_type'] !== 'amministratore') {
    die("Errore: Non hai i permessi per eliminare account.");
}

$id_user_to_delete = $_POST['id_user'] ?? null;

if (!$id_user_to_delete) {
    die("Errore: ID utente mancante.");
}

// Elimina l'utente dal database
$stmt = $conn->prepare("DELETE FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_user_to_delete);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Account eliminato con successo.";
    header('Location: ../../pub/index.php');
    exit();
} else {
    echo "Errore: Impossibile eliminare l'account.";
}
?>