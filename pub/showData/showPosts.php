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
    <style>
        :root {
            --orange: rgb(121, 29, 242);
            --twitter-dark: #15202b;
            --twitter-light-gray: #e1e8ed;
            --twitter-text-gray: #657786;
        }
        
        body {
            background-color: #f7f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            overflow-y: scroll;
        }
        
        .container.py-4 {
            max-width: 600px;
            margin: 0 auto;
            padding-top: 30px;
            padding-bottom: 30px;
            /* height: 100vh;  // RIMUOVI questa riga se presente */
            /* overflow-y: auto; // RIMUOVI questa riga se presente */
            /* Lo scroll sarà gestito dal body */
        }

        .post-card {
            background: #ffffff;
            border: none; /* Rimuovi il bordo */
            border-radius: 16px; /* Bordi arrotondati */
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombra leggera */
        }
        
        .post-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        
        .post-header {
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0; /* Separatore */
        }
        
        .post-body {
            padding: 16px;
            font-size: 1rem;
            line-height: 1.6;
            color: #333;
        }
        
        .post-actions {
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f0f0f0; /* Separatore */
            background-color: #f9f9f9; /* Sfondo leggero */
        }
        
        .btn-twitter {
            background: var(--twitter-blue);
            color: white;
            border-radius: 20px;
            padding: 4px 16px;
            font-weight: bold;
            border: none;
        }
        
        .btn-twitter:hover {
            background: rgb(242, 150, 29);
            color: white;
        }
        
        .btn-twitter-outline {
            background: transparent;
            color: var(--twitter-blue);
            border-radius: 20px;
            padding: 4px 16px;
            border: 1px solid var(--twitter-blue);
            font-weight: bold;
        }
        
        .btn-twitter-outline:hover {
            background: rgba(29, 161, 242, 0.1);
        }
        
        .participant-badge {
            background: var(--twitter-light-gray);
            border-radius: 12px;
            padding: 4px 8px;
            margin: 2px;
            display: inline-block;
            font-size: 0.8rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
            border: 2px solid #1da1f2; /* Aggiungi un bordo colorato */
        }
        
        .username {
            font-size: 0.9rem;
            color: #657786;
        }
        
        .post-time {
            font-size: 0.8rem;
            color: #aab8c2;
        }
        
        .action-btn {
            color: #657786;
            background: none;
            border: none;
            font-size: 1.2rem;
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .action-btn:hover {
            background-color: rgba(29, 161, 242, 0.1);
            color: #1da1f2;
        }
        
        .comment-form {
            padding: 12px 16px;
            border-top: 1px solid var(--twitter-light-gray);
            display: none;
        }
        
        .event-details {
            background-color: rgba(29, 161, 242, 0.05);
            border-radius: 12px;
            padding: 12px;
            margin-top: 12px;
            font-size: 0.9rem;
            color: #555;
        }
        
        .file-attachment a {
            color: #1da1f2;
            text-decoration: none;
            font-weight: bold;
        }
        
        .file-attachment a:hover {
            text-decoration: underline;
        }
        
        .no-posts {
            text-align: center;
            padding: 40px 20px;
            color: var(--twitter-text-gray);
        }
        
        .post-text {
            font-size: 1.1rem;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        /* Stile commento come in profile.php */
        .comment {
            border: 1px solid #e0e0e0;
            padding: 25px;
            margin: 20px auto 0 auto;
            border-radius: 15px;
            background-color: #f9f9f9;
            max-width: 750px;
            text-align: left;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .comment:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .toggle-comments-btn {
            background: #f3f6fa;
            color: #2575fc;
            border: none;
            border-radius: 20px;
            padding: 7px 22px;
            font-weight: 600;
            margin-bottom: 10px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .toggle-comments-btn:hover {
            background: #2575fc;
            color: #fff;
        }

        .modal,
        .modal-backdrop {
            z-index: 99999 !important;
        }
    </style>
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
                    <p class="post-text"><?= htmlspecialchars($postRow['description']) ?></p>

                    <?php if ($postRow['type_post'] == 3): ?>
                        <div class="event-details">
                            <i class="fas fa-info-circle"></i> 
                            <?php
                            $img = $postRow['image_path'] ? $postRow['image_path'] : '../priv/uploads/images/default.png'; 
                            echo '<img src="../priv/' . htmlspecialchars($img) . '" alt="Immagine post" class="img-fluid" style="max-width: 100%; height: auto;">';
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
                        <form class="partecipateForm mt-3" method="POST" action="../../priv/gestionePost/addPartecipantEvent.php">
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

<!-- Modale di successo per partecipazione eventi -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle"></i> Successo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body">
                <p>🎉 Partecipazione registrata con successo!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-twitter" data-bs-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>

<!-- Modale di successo per commenti -->
<div class="modal fade" id="commentSuccessModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: white;">
                <h5 class="modal-title"><i class="fas fa-check-circle"></i> Commento Aggiunto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body">
                <p>✅ Il tuo commento è stato aggiunto con successo!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: white;" data-bs-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>

<!-- Modale di errore -->
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-circle"></i> Errore</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body">
                <p>Si è verificato un errore durante l'operazione. Riprova più tardi.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
            </div>
        </div>
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
            url: "../../priv/gestionePost/addPartecipantEvent.php",
            method: "POST",
            data: formData,
            success: function(response) {
                $('#successModal').modal('show');
            },
            error: function(xhr, status, error) {
                $('#errorModal').modal('show');
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
                // Mostra il modal di successo
                $('#commentSuccessModal').modal('show');
                // Svuota il campo di input del commento
                form.find('input[name="comment"]').val('');
                // Aggiorna i commenti dopo l'invio senza ricaricare l'intera pagina
                var postId = form.find('input[name="id_post"]').val();
                updateComments(postId);
            },
            error: function(xhr, status, error) {
                $('#errorModal').modal('show');
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

    // Chiudi la modale e ricarica la pagina per il modal di partecipazione eventi
    $('#successModal').on('hidden.bs.modal', function () {
        location.reload();
    });

    // Non ricaricare la pagina alla chiusura del modal di commento (AJAX)
    $('#commentSuccessModal').on('hidden.bs.modal', function () {
        // Non fare nulla, la lista commenti si aggiorna già via AJAX
    });
});
</script>
</body>
</html>