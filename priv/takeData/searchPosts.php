<?php
// Controlla se è stata effettuata una ricerca
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($searchQuery)) {
    // Connessione al database (modifica con i tuoi parametri)

    // Query per cercare nei campi title, description e nome utente
    $stmt = $conn->prepare("
        SELECT p.*, u.name, u.surname, u.user_type 
        FROM posts p 
        JOIN users u ON p.id_user = u.id_user 
        WHERE p.title LIKE ? 
           OR p.description LIKE ?
    ");
    $likeQuery = '%' . $searchQuery . '%';
    $stmt->bind_param('ss', $likeQuery, $likeQuery);
    $stmt->execute();
    $resultPosts = $stmt->get_result();
}
?>