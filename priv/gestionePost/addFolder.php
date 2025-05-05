<?php
session_start();
include "../include/connessione.inc"; // Connessione al database

// Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: ../../pub/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dal form
    $folder_name = htmlspecialchars(trim($_POST['folder_name']));
    $folder_type = htmlspecialchars(trim($_POST['folder_type']));
    $id_user = $_SESSION['id_user'];

    // Verifica che i dati non siano vuoti
    //if (!empty($folder_name) && !empty($folder_type)) {
        // Prepara la query per inserire la cartella
        $query = "INSERT INTO folders (id_user, name, type) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $id_user, $folder_name, $folder_type);

        if ($stmt->execute()) {
            // Reindirizza al profilo con un messaggio di successo
            header('Location: profile.php?success=folder_created');
        } else {
            // Reindirizza al profilo con un messaggio di errore
            header('Location: profile.php?error=folder_creation_failed');
        }

        $stmt->close();
    //} else {
        // Reindirizza al profilo con un messaggio di errore
        //header('Location: profile.php?error=missing_data');
    //}
} else {
    header('Location: ../../pub/profile.php');
    exit();
}
?>