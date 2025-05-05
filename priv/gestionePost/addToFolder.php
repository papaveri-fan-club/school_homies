<?php
session_start(); // Inizio della sessione
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Utente non loggato.']);
    exit();
}

// Se il form è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id_user'];
    $id_post = $_POST['id_post'] ?? null;
    $id_folder = $_POST['folder'] ?? null;

    if (!$id_post || !$id_folder) {
        echo json_encode(['status' => 'error', 'message' => 'Dati mancanti.']);
        exit();
    }

    // Controlla se il post è già presente nella cartella
    $checkQuery = "SELECT * FROM foldersnotes WHERE id_folder = ? AND id_post = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    $stmtCheck->bind_param("ii", $id_folder, $id_post);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Il post è già presente
        echo json_encode(['status' => 'error', 'message' => 'Il post è già presente nella cartella.']);
    } else {
        // Inserisci nella tabella foldersnotes
        $query = "INSERT INTO foldersnotes (id_folder, id_post) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $id_folder, $id_post);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Post aggiunto con successo alla cartella.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Errore durante l\'aggiunta del post alla cartella.']);
        }

        $stmt->close();
    }

    $stmtCheck->close();
    $conn->close();
    exit();
}
?>