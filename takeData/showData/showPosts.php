<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed Social</title>
    <!-- Bootstrap CSS -->
    <link href="path/to/local/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome per icone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f7f9fa;
        }
        .post-card {
            border-radius: 12px;
            border: 1px solid #e1e8ed;
            transition: all 0.3s ease;
            margin-bottom: 16px;
        }
        .post-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-color: #ccd6dd;
        }
        .post-header {
            border-bottom: 1px solid #e1e8ed;
        }
        .post-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }
        .post-actions a {
            color: #657786;
            margin-right: 16px;
        }
        .post-actions a:hover {
            text-decoration: none;
        }
        .post-actions .comment:hover {
            color: #1da1f2;
        }
        .post-actions .bookmark:hover {
            color: #17bf63;
        }
        .event-details {
            background-color: #f5f8fa;
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
        }
        .participant-badge {
            margin-right: 4px;
            margin-bottom: 4px;
        }
        .participants-section {
            max-height: 120px;
            overflow-y: auto;
        }
        /* Stile per il modal di creazione post */
        .create-post-modal .modal-content {
            border-radius: 12px;
        }
        .create-post-modal .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }
        .create-post-modal .modal-body {
            padding-top: 0;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <!-- Header feed con UN SOLO pulsante Nuovo post -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Il tuo feed</h3>
                    <button class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#createPostModal">
                        <i class="fas fa-plus mr-2"></i>Nuovo post
                    </button>
                </div>

                <?php if ($resultPosts->num_rows > 0): ?>
                    <?php while ($postRow = $resultPosts->fetch_assoc()): ?>
                        <!-- Singolo post -->
                        <div class="post-card bg-white p-3">
                            <!-- Header post -->
                            <div class="d-flex align-items-center mb-3 post-header pb-3">
                                <img src="path/to/default/avatar.jpg" alt="Avatar" class="post-avatar mr-3">
                                <div>
                                    <h6 class="mb-0 font-weight-bold"><?= htmlspecialchars($postRow['name']) ?></h6>
                                    <small class="text-muted">@<?= strtolower(str_replace(' ', '', htmlspecialchars($postRow['name']))) ?> · <?= htmlspecialchars($postRow['date']) ?></small>
                                </div>
                            </div>
                            
                            <!-- Contenuto post -->
                            <div class="post-content mb-3">
                                <h5 class="font-weight-bold mb-2"><?= htmlspecialchars($postRow['title']) ?></h5>
                                <p class="mb-2"><?= htmlspecialchars($postRow['description']) ?></p>
                                
                                <?php if ($postRow['type_post'] == 2): ?>
                                    <!-- Dettagli evento -->
                                    <div class="event-details">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="far fa-calendar-alt mr-2"></i>
                                            <span class="font-weight-bold">Data evento:</span>
                                            <span class="ml-2"><?= htmlspecialchars($postRow['date_event']) ?></span>
                                        </div>
                                        
                                        <?php include "./takeData/takePartecipants.php"; ?>
                                        
                                        <div class="mb-2">
                                            <span class="font-weight-bold">Partecipanti:</span>
                                            <div class="participants-section mt-2">
                                                <?php while ($partecipantRow = $partecipantResult->fetch_assoc()): ?>
                                                    <span class="badge badge-light participant-badge">
                                                        <?= htmlspecialchars($partecipantRow['name']) ?> <?= htmlspecialchars($partecipantRow['surname']) ?>
                                                    </span>
                                                <?php endwhile; ?>
                                            </div>
                                        </div>
                                        
                                        <form class="partecipateForm mt-2" method="post">
                                            <input type="hidden" name="id_event" value="<?= $postRow['id_post'] ?>">
                                            <input type="hidden" name="id_partecipant" value="<?= $_SESSION['id_user'] ?>">
                                            <button class="btn btn-outline-primary btn-sm rounded-pill">
                                                <i class="fas fa-user-plus mr-1"></i> Partecipa
                                            </button>
                                        </form>
                                    </div>
                                <?php elseif ($postRow['type_post'] == 3): ?>
                                    <div class="event-details">
                                        <p class="mb-0"><strong>Extra:</strong> <?= htmlspecialchars($postRow['extra_field_3']) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Azioni post (solo commenta e salva) -->
                            <div class="post-actions d-flex">
                                <a href="#" class="comment mr-4" data-toggle="modal" data-target="#commentModal<?= $postRow['id_post'] ?>">
                                    <i class="far fa-comment mr-1"></i>
                                    <span>Commenta</span>
                                </a>
                                <a href="#" class="bookmark">
                                    <i class="far fa-bookmark mr-1"></i>
                                    <span>Salva</span>
                                </a>
                            </div>
                            
                            <!-- Sezione commenti (collassabile) -->
                            <div class="mt-3">
                                <?php include "./takeData/showData/showComments.php"; ?>
                            </div>
                        </div>
                        
                        <!-- Modal per commenti -->
                        <div class="modal fade" id="commentModal<?= $postRow['id_post'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Aggiungi commento</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php include "./form/formComment.php"; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="far fa-newspaper fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Nessun post disponibile</h4>
                        <p class="text-muted">Sii il primo a pubblicare qualcosa!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal per creare nuovo post (UNICO pulsante) -->
    <div class="modal fade create-post-modal" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Crea nuovo post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newPostForm" method="post" action="./gestionePost/createPost.php">
                        <div class="form-group">
                            <label for="postTitle">Titolo</label>
                            <input type="text" class="form-control" id="postTitle" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="postDescription">Descrizione</label>
                            <textarea class="form-control" id="postDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="postType">Tipo di post</label>
                            <select class="form-control" id="postType" name="type_post">
                                <option value="1">Post standard</option>
                                <option value="2">Evento</option>
                                <option value="3">Special</option>
                            </select>
                        </div>
                        <!-- Campi aggiuntivi per gli eventi -->
                        <div class="form-group" id="eventDateGroup" style="display: none;">
                            <label for="eventDate">Data evento</label>
                            <input type="datetime-local" class="form-control" id="eventDate" name="date_event">
                        </div>
                        <div class="form-group" id="extraFieldGroup" style="display: none;">
                            <label for="extraField">Campo speciale</label>
                            <input type="text" class="form-control" id="extraField" name="extra_field_3">
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill">Pubblica</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal di successo -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Operazione completata</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>I tuoi dati sono stati inviati correttamente!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="location.reload();">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        // Gestione del form di partecipazione
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
                    alert("Si è verificato un errore durante l'elaborazione della richiesta.");
                }
            });
        });

        // Animazione pulsanti interazione
        $('.post-actions a').hover(
            function() {
                $(this).find('i').css('transform', 'scale(1.2)');
            },
            function() {
                $(this).find('i').css('transform', 'scale(1)');
            }
        );

        // Mostra/nascondi campi aggiuntivi in base al tipo di post
        $('#postType').change(function() {
            var selectedType = $(this).val();
            
            // Nascondi tutti i campi aggiuntivi
            $('#eventDateGroup').hide();
            $('#extraFieldGroup').hide();
            
            // Mostra solo i campi pertinenti
            if(selectedType == '2') {
                $('#eventDateGroup').show();
            } else if(selectedType == '3') {
                $('#extraFieldGroup').show();
            }
        });

        // Gestione del form per nuovo post
        $('#newPostForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#createPostModal').modal('hide');
                    $('#successModal').modal('show');
                    // Ricarica la pagina dopo 2 secondi
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    alert("Si è verificato un errore durante la creazione del post.");
                }
            });
        });
    });
    </script>
</body>
</html>