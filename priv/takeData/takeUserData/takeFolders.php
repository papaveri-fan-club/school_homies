<?php

if (!isset($id_user)) {
    $id_user = $_SESSION['id_user'] ?? null;
}

if (!$id_user) {
    die("Errore: ID utente non specificato.");
}

if (!function_exists('getUserFolders')) {
    function getUserFolders($conn, $id_user) {
        // Recupera tutte le cartelle dell'utente specificato (private e pubbliche)
        $stmt = $conn->prepare("
            SELECT f.id_folder, f.name, f.type 
            FROM folders AS f 
            WHERE f.id_user = ?
        ");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return $stmt->get_result();
    }
}

if (!function_exists('getPublicFoldersOfOtherUsers')) {
    function getPublicFoldersOfOtherUsers($conn, $logged_user_id) {
        // Recupera solo le cartelle pubbliche degli altri utenti
        $stmt = $conn->prepare("
            SELECT f.id_folder, f.name, f.type, f.id_user 
            FROM folders AS f 
            WHERE f.type = 'public' AND f.id_user != ?
        ");
        $stmt->bind_param("i", $logged_user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}

// Determina quale query eseguire in base al contesto
if ($_SESSION['id_user'] == $id_user) {
    // L'utente sta visualizzando il proprio profilo
    $resultFoldersUser = getUserFolders($conn, $_SESSION['id_user']);
} else {
    // L'utente sta visualizzando il profilo di qualcun altro
    $resultFoldersUser = getPublicFoldersOfOtherUsers($conn, $_SESSION['id_user']);
}
?>