<?php
include "../include/connessione.inc";

// Controlla se il modulo è stato inviato
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera i dati dal modulo
    session_start();
    $id_post = $_POST['id_post'];
    $id_user = $_SESSION['id_user'];
    $comment = $_POST['comment'];

    //Esegue la query di inserimento
    $sql = "INSERT INTO comments (text, id_post, id_user) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $comment, $id_post, $id_user);

    if ($stmt->execute()) {
        echo "Commento aggiunto con successo!";
    } else {
        echo "Errore: " . $stmt->error;
    }

    // Chiusura della connessione
    $stmt->close();
    $conn->close();
}
?>