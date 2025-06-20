<?php
session_start();
include "../priv/include/connessione.inc";

// 1. Verifica se l'utente è loggato
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

// 2. Recupera e valida l'ID del post dall'URL
if (!isset($_GET['id_post']) || !filter_var($_GET['id_post'], FILTER_VALIDATE_INT)) {
    // Se l'ID non è valido o non è presente, reindirizza all'index
    header('Location: index.php');
    exit();
}
$id_post = $_GET['id_post'];

// 3. Prepara ed esegui la query per ottenere i dettagli del post e dell'utente
$query = "SELECT p.*, u.name, u.surname 
          FROM posts p 
          JOIN users u ON p.id_user = u.id_user 
          WHERE p.id_post = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_post);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc(); // Recupera il post come array associativo
$stmt->close();

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Il titolo della pagina ora è il titolo del post -->
    <title><?= htmlspecialchars($post['title'] ?? 'Post non trovato') ?></title>
    
    <!-- Link CSS necessari -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles/backgroundStyle.css">
    <link rel="stylesheet" href="styles/showPosts.css"> <!-- Per lo stile base della card -->
    <link rel="stylesheet" href="styles/viewPost.css">   <!-- Per gli stili specifici della pagina -->
    <style>
        /* --- Contenitore Principale --- */
        .main-content-view {
            position: relative;
            z-index: 1;
            padding: 50px 20px; /* Aumenta lo spazio verticale */
        }

        /* --- Card del Post Espansa --- */
        .expanded-post {
            max-width: 850px;
            margin: 0 auto 30px auto;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08); /* Ombra più morbida */
            border: 1px solid #e9ecef; /* Bordo sottile per definizione */
            overflow: hidden;
        }

        /* --- Header del Post --- */
        .expanded-post .post-header {
            padding: 25px 30px;
            border-bottom: 1px solid #e9ecef;
            background-color: #fdfdfd;
        }

        /* --- Corpo del Post (Miglioramenti per la leggibilità) --- */
        .expanded-post .post-body {
            padding: 35px 30px; /* Più padding per dare aria al testo */
        }

        .expanded-post .post-title {
            font-size: 2.5rem; /* Titolo più grande e d'impatto */
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 25px;
            color: #212529;
        }

        .expanded-post .post-text {
            font-size: 1.1rem; /* Aumenta la dimensione del font per il testo principale */
            line-height: 1.8; /* Aumenta l'interlinea, cruciale per testi lunghi */
            color: #495057;   /* Colore del testo più morbido del nero puro */
            margin-bottom: 30px;
        }

        /* --- Immagine del Post --- */
        .expanded-post .post-image {
            padding: 0 30px 30px 30px;
        }
        .expanded-post .post-image img {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 12px;
        }

        /* --- Dettagli Evento --- */
        .expanded-post .event-details {
            margin: 0 30px 30px 30px;
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-left: 4px solid #6a11cb;
            border-radius: 0 8px 8px 0;
        }

        /* --- Sezione Commenti (Visivamente separata) --- */
        .comments-section {
            padding: 30px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .comments-section h2 {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        /* --- Link per Tornare Indietro --- */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            background-color: rgba(0, 0, 0, 0.3);
            padding: 10px 20px;
            border-radius: 50px;
            max-width: 250px;
            margin-left: auto;
            margin-right: auto;
            transition: all 0.3s ease;
        }
        .back-link:hover {
            background-color: #fff;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Sfondo animato -->
    <div class="background-text" id="background-text"></div>

    <div class="main-content-view">
        <?php if ($post): ?>
            <!-- La card del post, con una classe aggiuntiva per ingrandirla -->
            <div class="post-card expanded-post">
                
                <!-- Header del post -->
                <div class="post-header">
                    <a href="profile.php?id_user=<?= $post['id_user'] ?>" class="user-link">
                        <div class="user-info">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($post['name'].'+'.$post['surname']) ?>&background=random" class="user-avatar">
                            <div>
                                <strong><?= htmlspecialchars($post['name'] . ' ' . $post['surname']) ?></strong>
                                <div class="username">@<?= strtolower(str_replace(' ', '', htmlspecialchars($post['name']))) ?></div>
                            </div>
                        </div>
                    </a>
                    <span class="post-time">
                        <?php if (!empty($post['created_at'])): ?>
                            <?= date('d M Y, H:i', strtotime($post['created_at'])) ?>
                        <?php endif; ?>
                    </span>
                </div>

                <!-- Corpo del post con titolo e descrizione completa -->
                <div class="post-body">
                    <h1 class="post-title"><?= htmlspecialchars($post['title']) ?></h1>
                    <p class="post-text"><?= nl2br(htmlspecialchars($post['description'])) ?></p>
                </div>

                <!-- Immagine del post, se presente -->
                <?php if (!empty($post['image_path'])): ?>
                    <div class="post-image">
                        <img src="../priv/<?= htmlspecialchars($post['image_path']) ?>" alt="Immagine del post" class="img-fluid">
                    </div>
                <?php endif; ?>

                <!-- Dettagli evento, se presente -->
                <?php if ($post['type_post'] == 2 && !empty($post['date_event'])): ?>
                    <div class="event-details">
                        <i class="fas fa-calendar-alt"></i> 
                        <strong>Data evento:</strong> <?= date('d/m/Y H:i', strtotime($post['date_event'])) ?>
                    </div>
                <?php endif; ?>

                <!-- Sezione Commenti -->
                <div class="comments-section">
                    <h2>Commenti</h2>
                    
                    <?php
                    // Soluzione per la compatibilità
                    $postRow = $post;
                    ?>

                    <!-- Form per aggiungere un nuovo commento -->
                    <div class="comment-form-container mb-4">
                        <?php include "./form/formComment.php"; ?>
                    </div>

                    <!-- Contenitore per mostrare i commenti esistenti -->
                    <div class="comments-list">
                        <?php 
                        include "../priv/takeData/takeComments.php";
                        include "./showData/showComments.php"; 
                        ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Messaggio di errore se il post non viene trovato -->
            <div class="post-card expanded-post">
                <div class="post-not-found">
                    <h1><i class="fas fa-exclamation-triangle"></i> Post non Trovato</h1>
                    <p>Il post che stai cercando non esiste o è stato rimosso.</p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Link per tornare al feed -->
        <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Torna al feed principale</a>
    </div>

    <!-- Script necessari -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="styles/backgroundStyle.js"></script>
</body>
</html>