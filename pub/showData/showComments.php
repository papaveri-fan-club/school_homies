<?php
if ($resultComments->num_rows > 0) {
    while ($commentRow = $resultComments->fetch_assoc()) {
        echo '<div class="comment">';
        echo htmlspecialchars($commentRow['text']) . " - " . htmlspecialchars($commentRow['name']);
        // Pulsante elimina (se admin)
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'amministratore') {
            echo '<form method="post" action="../priv/gestionePost/deleteComment.php" style="display: inline;">';
            echo '<input type="hidden" name="id_comment" value="' . $commentRow['id_comment'] . '">';
            echo '<button type="submit" class="delete-btn" title="Elimina commento"><i class="fas fa-trash"></i></button>';
            echo '</form>';
        }
        echo '</div>';
    }
} else {
    echo "<p class='no-content'>Nessun commento presente.</p>";
}
?>

<style>
.delete-btn {
    background: none;
    border: none;
    color: #888;
    font-size: 1.1rem;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 50%;
    transition: color 0.2s, background 0.2s;
}
.delete-btn:hover,
.delete-btn:focus {
    color: #fff;
    background: #e74c3c;
    outline: none;
}
.delete-btn i {
    pointer-events: none;
}
</style>

<!-- Modale di successo per commento -->
<div class="modal fade" id="commentSuccessModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle"></i> Successo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body">
                <p>✅ Commento aggiunto con successo!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-twitter" data-bs-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>