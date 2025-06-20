<?php
// Inizio del file PHP
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Feed</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome per le icone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Link al nuovo file CSS -->
    <link rel="stylesheet" href="styles/showPosts.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/button.css">
    
    <!-- Rimosso il blocco <style>...</style> -->

</head>
<body>
<div class="container py-4">

    <?php
    include '../priv/takeData/takeUserData/takeFolders.php';

    // Recupera le cartelle dell'utente loggato
    $resultFolders = getUserFolders($conn, $_SESSION['id_user']);

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        echo '<div class="alert alert-' . ($message['status'] === 'success' ? 'success' : 'danger') . '">';
        echo htmlspecialchars($message['text']);
        echo '</div>';
    }
    ?>

    <?php if ($resultPosts->num_rows > 0): ?>
        <?php while ($postRow = $resultPosts->fetch_assoc()): ?>
            <div class="post-card">
                <div class="post-header">
                    <!-- Informazioni sull'utente -->
                    <a href="profile.php?id_user=<?= $postRow['id_user'] ?>">
                        <div class="user-info">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($postRow['name']) ?>&background=random" class="user-avatar">
                            <div>
                                <strong><?= htmlspecialchars($postRow['name']) ?></strong>
                                <div class="username">@<?= strtolower(str_replace(' ', '', htmlspecialchars($postRow['name']))) ?></div>
                            </div>
                        </div>
                    </a>
                    <span class="post-time"><?= htmlspecialchars($postRow['date']) ?></span>

                    <!-- Pulsante Elimina Post -->
                    <?php if (
                        (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $postRow['id_user'] && basename($_SERVER['PHP_SELF']) === 'profile.php') || 
                        (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'amministratore')
                    ): ?>
                        <form method="post" action="../priv/gestionePost/deletePost.php" style="position: absolute; top: 10px; right: 10px;">
                            <input type="hidden" name="id_post" value="<?= $postRow['id_post']; ?>">
                            <button type="submit" class="delete-btn" title="Elimina post">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <div class="post-body">
                    <h5 class="mb-2"><strong><?= htmlspecialchars($postRow['title']) ?></strong></h5>
                    <p class="post-text"><?= nl2br(htmlspecialchars($postRow['description'])) ?></p>

                    <?php if ($postRow['type_post'] == 3): ?>
                        <div class="event-details">
                            <i class="fas fa-info-circle"></i> 
                            <?php
                            echo $postRow['image_path'];
                            $img = $postRow['image_path'] ? $postRow['image_path'] : '../priv/uploads/images/default.png'; 
                            echo '<img src="../priv/uploads/'. htmlspecialchars($img) . '" alt="Immagine post" class="img-fluid" style="max-width: 100%; height: auto;">';
                            ?>
                        </div>
                        <?php if (!empty($postRow['file_path'])): ?>
                            <div class="file-attachment mt-3">
                                <i class="fas fa-paperclip"></i> 
                                <a href="<?= htmlspecialchars($postRow['file_path']) ?>" target="_blank" download>
                                    Scarica allegato
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($postRow['type_post'] == 2): ?>
                        <div class="event-details">
                            <i class="fas fa-calendar-alt"></i> 
                            <strong>Data evento:</strong> <?= htmlspecialchars($postRow['date_event']) ?>
                        </div>

                        <!-- Form per partecipare all'evento -->
                        <form class="partecipateForm mt-3">
                            <input type="hidden" name="id_event" value="<?= $postRow['id_post'] ?>">
                            <button type="submit" class="btn btn-twitter">Partecipa</button>
                        </form>

                        <!-- Mostra i partecipanti -->
                        <div class="mt-3">
                            <h6>Partecipanti:</h6>
                            <?php
                            include '../priv/takeData/takePartecipants.php';
                            if ($partecipantResult->num_rows > 0) {
                                while ($participant = $partecipantResult->fetch_assoc()) {
                                    echo '<span class="participant-badge">' . htmlspecialchars($participant['name']) . ' ' . htmlspecialchars($participant['surname']) . '</span>';
                                }
                            } else {
                                echo '<p class="text-muted">Nessun partecipante al momento.</p>';
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="post-actions">
                    <button class="action-btn toggle-comment" data-post-id="<?= $postRow['id_post'] ?>">
                        <i class="far fa-comment"></i>
                    </button>
                    <?php include "./form/formAddToFolder.php"; ?>
                </div>
                <div class="comment-form" id="comment-form-<?= $postRow['id_post'] ?>">
                    <?php include "./form/formComment.php"; ?>
                </div>
                
                <div class="px-3 pb-2">
                    <button class="toggle-comments-btn" data-post-id="<?= $postRow['id_post'] ?>">Show more</button>
                    <div class="comments-container" id="comments-<?= $postRow['id_post'] ?>" style="display: none;">
                        <?php 
                        include "../priv/takeData/takeComments.php";
                        include "./showData/showComments.php"; 
                        ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-posts">
            <i class="far fa-newspaper fa-3x mb-3"></i>
            <h4>Nessun post presente</h4>
            <p>Sii il primo a creare un post!</p>
        </div>
    <?php endif; ?>
</div>

<!-- Popup personalizzati simili a profile.php -->
<!-- Popup per successo partecipazione evento -->
<div class="popup-overlay" id="participation-popup-overlay"></div>
<div class="popup" id="participation-popup">
    <h3><i class="fas fa-check-circle"></i> Partecipazione Registrata</h3>
    <p>🎉 La tua partecipazione all'evento è stata registrata con successo!</p>
    <div class="btn-group">
        <button type="button" class="btn" onclick="closeParticipationPopup()">Chiudi</button>
    </div>
</div>

<!-- Popup per successo commento -->
<div class="popup-overlay" id="comment-popup-overlay"></div>
<div class="popup" id="comment-popup">
    <h3><i class="fas fa-check-circle"></i> Commento Aggiunto</h3>
    <p>✅ Il tuo commento è stato aggiunto con successo!</p>
    <div class="btn-group">
        <button type="button" class="btn" onclick="closeCommentPopup()">Chiudi</button>
    </div>
</div>

<!-- Popup per errore -->
<div class="popup-overlay" id="error-popup-overlay"></div>
<div class="popup" id="error-popup">
    <h3><i class="fas fa-exclamation-circle"></i> Errore</h3>
    <p>Si è verificato un errore durante l'operazione. Riprova più tardi.</p>
    <div class="btn-group">
        <button type="button" class="btn" onclick="closeErrorPopup()">Chiudi</button>
    </div>
</div>

<!-- Includi jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Gestione partecipazione evento
    $(document).on("submit", ".partecipateForm", function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "../priv/gestionePost/addPartecipantEvent.php",
            method: "POST",
            data: formData,
            success: function(response) {
                openParticipationPopup();
            },
            error: function(xhr, status, error) {
                openErrorPopup();
            }
        });
    });

    // Gestione invio commenti
    $(document).on("submit", ".commentForm", function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var form = $(this);

        $.ajax({
            url: "../priv/gestionePost/addComment.php",
            method: "POST",
            data: formData,
            success: function(response) {
                // Mostra il popup di successo
                openCommentPopup();
                // Svuota il campo di input del commento
                form.find('input[name="comment"]').val('');
                // Aggiorna i commenti dopo l'invio senza ricaricare l'intera pagina
                var postId = form.find('input[name="id_post"]').val();
                updateComments(postId);
            },
            error: function(xhr, status, error) {
                openErrorPopup();
            }
        });
    });

    // Funzione per aggiornare i commenti di un post specifico
    function updateComments(postId) {
        $.ajax({
            url: "../priv/takeData/getCommentsAjax.php",
            method: "GET",
            data: { id_post: postId },
            success: function(response) {
                // Aggiorna la sezione dei commenti con i nuovi dati
                var commentContainer = $('#comment-form-' + postId).siblings('.px-3.pb-2').find('.comments-container');
                commentContainer.html(response);
            }
        });
    }

    // Mostra/nascondi form commenti
    $(".toggle-comment").click(function() {
        var postId = $(this).data('post-id');
        $("#comment-form-" + postId).slideToggle();
    });

    // Mostra/nascondi commenti esistenti
    $(".toggle-comments-btn").click(function() {
        var postId = $(this).data('post-id');
        var $commentsDiv = $("#comments-" + postId);
        $commentsDiv.slideToggle(200);

        // Cambia il testo del pulsante in base alla visibilità DOPO l'animazione
        var $btn = $(this);
        setTimeout(function() {
            if ($commentsDiv.is(":visible")) {
                $btn.text("Nascondi");
            } else {
                $btn.text("Show more");
            }
        }, 210);
    });
});

// Funzioni per i popup
function openParticipationPopup() {
    document.getElementById('participation-popup').style.display = 'block';
    document.getElementById('participation-popup-overlay').style.display = 'block';
}

function closeParticipationPopup() {
    document.getElementById('participation-popup').style.display = 'none';
    document.getElementById('participation-popup-overlay').style.display = 'none';
    // Ricarica la pagina dopo che l'utente ha chiuso il popup
    location.reload();
}

function openCommentPopup() {
    document.getElementById('comment-popup').style.display = 'block';
    document.getElementById('comment-popup-overlay').style.display = 'block';
}

function closeCommentPopup() {
    document.getElementById('comment-popup').style.display = 'none';
    document.getElementById('comment-popup-overlay').style.display = 'none';
    // Non ricaricare la pagina in questo caso
    location.reload();
}

function openErrorPopup() {
    document.getElementById('error-popup').style.display = 'block';
    document.getElementById('error-popup-overlay').style.display = 'block';
}

function closeErrorPopup() {
    document.getElementById('error-popup').style.display = 'none';
    document.getElementById('error-popup-overlay').style.display = 'none';
}
</script>
</body>
</html>
