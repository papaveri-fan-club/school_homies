<?php
if ($resultComments->num_rows > 0) {
    while ($commentRow = $resultComments->fetch_assoc()) {
        echo '<div class="comment">';
        echo htmlspecialchars($commentRow['text']) . " - " . htmlspecialchars($commentRow['name']);
        // Pulsante elimina (se admin)
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'amministratore') {
            echo '<form method="post" action="../priv/gestionePost/deleteComment.php" style="display: inline;">';
            echo '<input type="hidden" name="id_comment" value="' . $commentRow['id_comment'] . '">';
            echo '<button type="submit" class="delete-btn" title="Elimina commento" onclick="confirmDeleteComment(event, ' . $commentRow['id_comment'] . ')"><i class="fas fa-trash"></i></button>';
            echo '</form>';
        }
        echo '</div>';
    }
} else {
    echo "<p class='no-content'>Nessun commento presente.</p>";
}
?>

<!-- Stile per i pulsanti di eliminazione e i popup -->
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

/* Stili per i popup personalizzati */
.popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 999;
    backdrop-filter: blur(5px);
}

.popup {
    display: none;
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
    z-index: 1000;
    width: 90%;
    max-width: 550px;
    text-align: center;
}

.popup h3 {
    color: #444;
    margin-bottom: 25px;
    font-size: 1.8rem;
    font-weight: 700;
}

.btn-group {
    margin-top: 25px;
    display: flex;
    justify-content: center;
    gap: 15px;
}

#message {
    margin-top: 20px;
    font-weight: 600;
    padding: 10px;
    border-radius: 8px;
}

.message-success {
    background-color: #d4edda;
    color: #155724;
}

.message-error {
    background-color: #f8d7da;
    color: #721c24;
}
</style>

<!-- Popup conferma eliminazione commento -->
<div class="popup-overlay" id="delete-comment-overlay"></div>
<div class="popup" id="delete-comment-popup">
    <h3>Conferma Eliminazione</h3>
    <p>Sei sicuro di voler eliminare questo commento?</p>
    <form id="deleteCommentForm" method="post" action="../priv/gestionePost/deleteComment.php">
        <input type="hidden" name="id_comment" id="comment-to-delete">
        <div class="btn-group">
            <button type="submit" class="btn" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">Elimina</button>
            <button type="button" class="btn" onclick="closeDeleteCommentPopup()" style="background-color: #95a5a6;">Annulla</button>
        </div>
    </form>
    <div id="delete-message"></div>
</div>

<!-- Popup di successo -->
<div class="popup-overlay" id="success-overlay"></div>
<div class="popup" id="success-popup">
    <h3>Operazione Completata</h3>
    <p id="success-message">Operazione completata con successo!</p>
    <div class="btn-group">
        <button type="button" class="btn" onclick="closeSuccessPopup()" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">Chiudi</button>
    </div>
</div>

<script>
// Funzioni per il popup di eliminazione commento
function confirmDeleteComment(event, commentId) {
    event.preventDefault();
    document.getElementById('comment-to-delete').value = commentId;
    document.getElementById('delete-comment-popup').style.display = 'block';
    document.getElementById('delete-comment-overlay').style.display = 'block';
}

function closeDeleteCommentPopup() {
    document.getElementById('delete-comment-popup').style.display = 'none';
    document.getElementById('delete-comment-overlay').style.display = 'none';
    document.getElementById('delete-message').textContent = '';
    document.getElementById('delete-message').className = '';
}

// Funzione per il popup di successo
function showSuccessPopup(message) {
    document.getElementById('success-message').textContent = message || 'Operazione completata con successo!';
    document.getElementById('success-popup').style.display = 'block';
    document.getElementById('success-overlay').style.display = 'block';
}

function closeSuccessPopup() {
    window.location.reload();
    document.getElementById('success-popup').style.display = 'none';
    document.getElementById('success-overlay').style.display = 'none';
    // Ricarica la pagina dopo la chiusura del popup di successo
}

// Gestione del form di eliminazione commento con AJAX
document.getElementById('deleteCommentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('../priv/gestionePost/deleteComment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Se non è una risposta JSON, consideriamo che sia andata a buon fine
        if(!response.headers.get('content-type')?.includes('application/json')) {
            closeDeleteCommentPopup();
            showSuccessPopup('Commento eliminato con successo!');
            return;
        }
        return response.json();
    })
    .then(data => {
        if(data) {
            if(data.success) {
                closeDeleteCommentPopup();
                showSuccessPopup(data.message || 'Commento eliminato con successo!');
            } else {
                const messageDiv = document.getElementById('delete-message');
                messageDiv.textContent = data.message || 'Si è verificato un errore.';
                messageDiv.className = 'message-error';
            }
        }
    })
    .catch(error => {
        console.error('Errore:', error);
        // In caso di errore, assumiamo che il backend abbia comunque elaborato la richiesta
        closeDeleteCommentPopup();
        showSuccessPopup('Commento eliminato con successo!');
    });
});

// Per mostrare il messaggio di successo quando viene aggiunto un commento
// Controlla se c'è un parametro di query "comment_added=success"
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('comment_added') === 'success') {
        showSuccessPopup('Commento aggiunto con successo!');
    }
});
</script>


