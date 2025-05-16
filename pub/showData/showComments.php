<?php
if ($resultComments->num_rows > 0) {
    echo "<ul>";
    while ($commentRow = $resultComments->fetch_assoc()) {
        echo "<li>";
        echo htmlspecialchars($commentRow['text']) . " - " . htmlspecialchars($commentRow['name']);
        
        // Mostra il pulsante "Elimina Commento" solo per gli amministratori
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'amministratore') {
            echo '<form method="post" action="../priv/gestionePost/deleteComment.php" style="display: inline;">';
            echo '<input type="hidden" name="id_comment" value="' . $commentRow['id_comment'] . '">';
            echo '<button type="submit" class="btn btn-danger btn-sm">Elimina</button>';
            echo '</form>';
        }

        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Nessun commento presente.";
}
?>