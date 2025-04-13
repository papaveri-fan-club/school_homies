<?php
// Controlla se è stata effettuata una ricerca
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($searchQuery)) {
    // Connessione al database (modifica con i tuoi parametri)
    include './include/connessione.inc';

    // Query per cercare nei campi title, description e nome utente
    $stmt = $conn->prepare("
        SELECT posts.*, users.name, users.surname 
        FROM posts 
        JOIN users ON posts.id_user = users.id_user
        WHERE posts.title LIKE ? 
           OR posts.description LIKE ? 
           OR CONCAT(users.name, ' ', users.surname) LIKE ?
    ");
    $likeQuery = '%' . $searchQuery . '%';
    $stmt->bind_param('sss', $likeQuery, $likeQuery, $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    // Mostra i risultati della ricerca
    if ($result->num_rows > 0) {
        while ($post = $result->fetch_assoc()) {
            echo "<div style='padding: 10px; border: 1px solid #e1e8ed; border-radius: 10px; margin-bottom: 10px;'>";
            echo "<h3>" . htmlspecialchars($post['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($post['description']) . "</p>";
            echo "<small>Postato da: " . htmlspecialchars($post['name']) . " " . htmlspecialchars($post['surname']) . "</small>";
            echo "</div>";
        }
    } else {
        echo "<p>Nessun risultato trovato per '<strong>" . htmlspecialchars($searchQuery) . "</strong>'</p>";
    }
}
?>