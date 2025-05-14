<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    echo json_encode(['success' => false, 'message' => 'Utente non loggato.']);
    exit();
}

$id_user = $_SESSION['id_user'];
$id_folder = $_POST['id_folder'];

// Controlla se l'utente è un amministratore
$stmt = $conn->prepare("SELECT user_type FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['user_type'] === 'amministratore') {
    // Gli amministratori possono eliminare qualsiasi cartella pubblica
    $query = $conn->prepare("DELETE FROM folders WHERE id_folder = ? AND type = 'public'");
    $query->bind_param("i", $id_folder);
} else {
    // Gli utenti normali possono eliminare solo le proprie cartelle
    $query = $conn->prepare("DELETE FROM folders WHERE id_folder = ? AND id_user = ?");
    $query->bind_param("ii", $id_folder, $id_user);
}

$query->execute();
echo json_encode(['success' => true, 'message' => 'Cartella eliminata con successo.']);
exit();
?>