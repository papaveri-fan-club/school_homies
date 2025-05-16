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

// Inizia una transazione per garantire la coerenza dei dati
$conn->begin_transaction();

try {
    // Elimina i commenti dell'utente
    $stmt = $conn->prepare("DELETE FROM comments WHERE id_user = ?");
    $stmt->bind_param("i", $id_user_to_delete);
    $stmt->execute();

    // Elimina i post dell'utente
    $stmt = $conn->prepare("DELETE FROM posts WHERE id_user = ?");
    $stmt->bind_param("i", $id_user_to_delete);
    $stmt->execute();

    // Elimina le cartelle dell'utente
    $stmt = $conn->prepare("DELETE FROM folders WHERE id_user = ?");
    $stmt->bind_param("i", $id_user_to_delete);
    $stmt->execute();

    // Elimina le partecipazioni agli eventi
    $stmt = $conn->prepare("DELETE FROM partecipantsevents WHERE id_partecipant = ?");
    $stmt->bind_param("i", $id_user_to_delete);
    $stmt->execute();

    // Elimina i token di verifica email
    $stmt = $conn->prepare("DELETE FROM email_verifications WHERE id_user = ?");
    $stmt->bind_param("i", $id_user_to_delete);
    $stmt->execute();

    // Elimina l'utente dalla tabella `users`
    $stmt = $conn->prepare("DELETE FROM users WHERE id_user = ?");
    $stmt->bind_param("i", $id_user_to_delete);
    $stmt->execute();

    // Conferma la transazione
    $conn->commit();

    echo "Account e dati correlati eliminati con successo.";
    header('Location: ../../pub/index.php');
    exit();
} catch (Exception $e) {
    // Annulla la transazione in caso di errore
    $conn->rollback();
    die("Errore durante l'eliminazione dell'utente: " . $e->getMessage());
}
?>