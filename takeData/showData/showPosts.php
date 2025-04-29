<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School_Homies</title>
    <!-- Bootstrap CSS -->
    <link href="path/to/local/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome per le icone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --orange: rgb(242, 150, 29);
            --twitter-dark: #15202b;
            --twitter-light-gray: #e1e8ed;
            --twitter-text-gray: #657786;
        }
        
        body {
            background-color: #f7f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        
        .post-card {
            background: #fff;
            border: 1px solid var(--twitter-light-gray);
            border-radius: 16px;
            margin-bottom: 16px;
            transition: 0.3s;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .post-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .post-header {
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .post-body {
            padding: 12px 16px;
        }
        
        .post-actions {
            padding: 8px 16px;
            display: flex;
            justify-content: space-between;
            border-top: 1px solid var(--twitter-light-gray);
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
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
        }
        
        .username {
            color: var(--twitter-text-gray);
            font-size: 0.9rem;
        }
        
        .post-time {
            color: var(--twitter-text-gray);
            font-size: 0.9rem;
        }
        
        .action-btn {
            color: var(--twitter-text-gray);
            background: none;
            border: none;
            font-size: 1rem;
            padding: 8px;
            border-radius: 50%;
            transition: 0.2s;
        }
        
        .action-btn:hover {
            background: rgba(29, 161, 242, 0.1);
            color: var(--twitter-blue);
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
    </style>
</head>
<body>
    <div class="container py-4">
        <?php if ($resultPosts->num_rows > 0): ?>
            <?php while ($postRow = $resultPosts->fetch_assoc()): ?>
                <div class="post-card">
                    <div class="post-header">
                        <div class="user-info">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($postRow['name']) ?>&background=random" class="user-avatar">
                            <div>
                                <strong><?= htmlspecialchars($postRow['name']) ?></strong>
                                <div class="username">@<?= strtolower(str_replace(' ', '', htmlspecialchars($postRow['name']))) ?></div>
                            </div>
                        </div>
                        <span class="post-time"><?= htmlspecialchars($postRow['date']) ?></span>
                    </div>

                    <div class="post-body">
                        <h5 class="mb-2"><strong><?= htmlspecialchars($postRow['title']) ?></strong></h5>
                        <p class="post-text"><?= htmlspecialchars($postRow['description']) ?></p>

                        <?php if ($postRow['type_post'] == 2): ?>
                            <div class="event-details">
                                <div class="mb-2">
                                    <i class="far fa-calendar-alt"></i> 
                                    <strong>Data evento:</strong> <?= htmlspecialchars($postRow['date_event']) ?>
                                </div>
                                
                                <div class="mb-2">
                                    <i class="fas fa-users"></i> 
                                    <strong>Partecipanti:</strong>
                                    <div class="mt-1">
                                        <?php include "./takeData/takePartecipants.php"; ?>
                                        <?php while ($partecipantRow = $partecipantResult->fetch_assoc()): ?>
                                            <span class="participant-badge">
                                                <?= htmlspecialchars($partecipantRow['name']) ?> <?= htmlspecialchars($partecipantRow['surname']) ?>
                                            </span>
                                        <?php endwhile; ?>
                                    </div>
                                </div>

                                <form class="partecipateForm mt-2" method="post">
                                    <input type="hidden" name="id_event" value="<?= $postRow['id_post'] ?>">
                                    <input type="hidden" name="id_partecipant" value="<?= $_SESSION['id_user'] ?>">
                                    <button type="submit" class="btn-twitter-outline">
                                        <i class="fas fa-hand-paper"></i> Partecipa
                                    </button>
                                </form>
                            </div>

                        <?php elseif ($postRow['type_post'] == 3): ?>
                            <div class="event-details">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Dettagli:</strong> <?= htmlspecialchars($postRow['extra_field_3']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="post-actions">
                        <button class="action-btn toggle-comment" data-post-id="<?= $postRow['id_post'] ?>">
                            <i class="far fa-comment"></i>
                        </button>
                        <button class="action-btn">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="action-btn">
                            <i class="far fa-bookmark"></i>
                        </button>
                        <?php include "./gestionePost/addToFolder.php"; ?>
                    </div>

                    <div class="comment-form" id="comment-form-<?= $postRow['id_post'] ?>">
                        <?php include "./form/formComment.php"; ?>
                    </div>
                    
                    <div class="px-3 pb-2">
                        <?php include "./takeData/showData/showComments.php"; ?>
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

    <!-- Modale di successo -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-check-circle"></i> Successo</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>🎉 Partecipazione registrata con successo!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-twitter" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Includi jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Includi Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Gestione partecipazione evento
        $(document).on("submit", ".partecipateForm", function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            
            $.ajax({
                url: "./gestionePost/addPartecipantEvent.php",
                method: "POST",
                data: formData,
                success: function(response) {
                    $('#successModal').modal('show');
                },
                error: function(xhr, status, error) {
                    alert("Si è verificato un errore durante l'operazione.");
                }
            });
        });
        
        // Mostra/nascondi form commenti
        $(".toggle-comment").click(function() {
            var postId = $(this).data('post-id');
            $("#comment-form-" + postId).slideToggle();
        });
        
        // Chiudi la modale e ricarica la pagina
        $('#successModal').on('hidden.bs.modal', function () {
            location.reload();
        });
    });
    </script>
</body>
</html>